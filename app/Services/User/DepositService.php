<?php

namespace App\Services\User;

use App\Models\User\Deposit;
use App\Models\User\DepositActions;
use App\Models\User\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Exceptions\User\InsufficientFundsException;
use App\Exceptions\User\UserNotFoundException;

class DepositService {
    protected $user;

    public function __construct(User $user = null)
    {
        $this->user = $user ?? Auth::user();
    }

    public function deposit($data = null): ?float
    {
        return DB::transaction(function () use ($data) {
            $user = User::where('id', $data['to_user_id'])->first();

            if (!$user) {
                throw new UserNotFoundException();
            }

            $deposit = $this->createDepositIfNotExist($user);
            $deposit->balance += $data['amount'];
            $deposit->save();

            DepositActions::create([
                'from_user_id' => auth()->user()->id,
                'to_user_id' => $data['to_user_id'],
                'type' => 'deposit',
                'amount' => $data['amount'],
                'comment' => $data['comment'],
            ]);

            return $deposit->balance;
        });
    }

    public function withdraw($data = null)
    {
        return DB::transaction(function () use ($data) {
            $user = User::where('id', $data['from_user_id'])->first();

            if (!$user) {
                throw new UserNotFoundException();
            }

            $deposit = $this->createDepositIfNotExist($user);

            if ($deposit->balance < $data['amount']) {
                throw new InsufficientFundsException();
            }

            $deposit->balance -= $data['amount'];
            $deposit->save();

            DepositActions::create([
                'from_user_id' => $data['from_user_id'],
                'to_user_id' => auth()->user()->id,
                'type' => 'withdraw',
                'amount' => $data['amount'],
                'comment' => $data['comment'],
            ]);

            return round($deposit->balance, 2);
        });
    }

    public function transfer($data = null)
    {
        return DB::transaction(function () use ($data) {
            $sender = User::where('id', $data['from_user_id'])->first();
            $recipient = User::where('id', $data['to_user_id'])->first();

            if (!$sender || !$recipient) {
                throw new UserNotFoundException();
            }

            $senderDeposit = $this->createDepositIfNotExist($sender);

            if ($senderDeposit->balance < $data['amount']) {
                throw new InsufficientFundsException();
            }

            $recipientDeposit = $this->createDepositIfNotExist($recipient);

            $senderDeposit->balance -= round((float) $data['amount'], 2);
            $recipientDeposit->balance += round((float) $data['amount'], 2);

            $senderDeposit->save();
            $recipientDeposit->save();

            DepositActions::create([
                'from_user_id' => $data['from_user_id'],
                'to_user_id' => $data['to_user_id'],
                'type' => 'transfer_out',
                'amount' => $data['amount'],
                'comment' => $data['comment'],
            ]);

            DepositActions::create([
                'from_user_id' => $data['from_user_id'],
                'to_user_id' => $data['to_user_id'],
                'type' => 'transfer_in',
                'amount' => $data['amount'],
                'comment' => $data['comment'],
            ]);

            return [
                'senderBalance' => round($senderDeposit->balance, 2),
                'recipientBalance' => round($recipientDeposit->balance, 2),
            ];
        });
    }

    public function balance(int $user_id): float
    {
        $user = User::where('id', $user_id)->first();

        if (!$user) {
            throw new UserNotFoundException();
        }

        $deposit = $this->createDepositIfNotExist($user);

        return round($deposit->balance, 2);
    }

    protected function createDepositIfNotExist(User $user): Deposit
    {
        if (!$user->deposit) {
            $deposit = new Deposit();
            $deposit->user_id = $user->id;
            $deposit->balance = 0;
            $deposit->save();
            
            return $deposit;
        }

        return $user->deposit;
    }
}
