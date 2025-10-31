<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\DepositRequest;
use App\Http\Requests\User\TransferRequest;
use App\Http\Requests\User\WithdrawRequest;
use App\Services\User\DepositService;
use App\Exceptions\User\UserNotFoundException;
use App\Exceptions\User\InsufficientFundsException;
use Illuminate\Http\JsonResponse;

class ApiDepositController extends Controller
{ 
    public function deposit(DepositRequest $request, DepositService $depositService): JsonResponse
    {
        try { 
            $validData = $request->validated();

            if ($result = $depositService->deposit($validData)) {
                $message = 'Баланс пользователя: ' . $validData['to_user_id'] . ' Пополнен на: ' . $validData['amount'];

                return $this->success($result, $message);
            }
            
            throw new \Exception('Ошибка пополнения баланса');
        } catch (UserNotFoundException $error) {
            return $this->conflict($error, $error->getMessage());
        } catch (InsufficientFundsException $error) {
            return $this->conflict($error, $error->getMessage());
        } catch (\Exception $error) {
            return $this->conflict($error, $error->getMessage());
        }
    }

    public function withdraw(WithdrawRequest $request, DepositService $depositService): JsonResponse
    {
        try {
            $validData = $request->validated();
            $result = $depositService->withdraw($validData);
            $message = 'Баланс пользователя: ' . $validData['from_user_id'] . ' Уменьшен на: ' . $validData['amount'];

            return $this->success($result, $message);
        } catch (UserNotFoundException $error) {
            return $this->conflict($error, $error->getMessage());
        } catch (InsufficientFundsException $error) {
            return $this->conflict($error, $error->getMessage());
        } catch (\Exception $error) {
            return $this->conflict($error, $error->getMessage());
        }
    }

    public function transfer(TransferRequest $request, DepositService $depositService): JsonResponse
    {
        try {
            $validData = $request->validated();
            $result = $depositService->transfer($validData);
            $message = 'Пользователь: ' . $validData['from_user_id'] . ' '; 
            $message .= 'Перевел: ' . $validData['amount'] . ' ' . 'Пользователю: ' . $validData['to_user_id'];

            return $this->success($result, $message);
        } catch (UserNotFoundException $error) {
            return $this->conflict($error, $error->getMessage());
        } catch (InsufficientFundsException $error) {
            return $this->conflict($error, $error->getMessage());
        } catch (\Exception $error) {
            return $this->conflict($error, $error->getMessage());
        }
    }

    public function balance(int $user_id, DepositService $depositService): JsonResponse
    {
        try {
            $balance = $depositService->balance($user_id);
            $message = 'Баланс пользователя: ' . $balance;

            return $this->success($balance, $message);
        } catch (UserNotFoundException $error) {
            return $this->conflict($error, $error->getMessage());
        } catch (InsufficientFundsException $error) {
            return $this->conflict($error, $error->getMessage());
        } catch (\Exception $error) {
            return $this->conflict($error, $error->getMessage());
        }
    }
}
