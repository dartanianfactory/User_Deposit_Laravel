<?php

namespace App\Models\User;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;

class DepositActions extends Model
{
    protected $fillable = [
        'from_user_id',
        'to_user_id',
        'type',
        'amount',
    ];

    public function fromUser()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function toUser()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }

    public function scopeDeposits($query)
    {
        return $query->where('type', 'deposit');
    }
    public function scopeWithdrawals($query)
    {
        return $query->where('type', 'withdraw');
    }

    public function scopeTransfersOut($query)
    {
        return $query->where('type', 'transfer_out');
    }

    public function scopeTransfersIn($query)
    {
        return $query->where('type', 'transfer_in');
    }
}