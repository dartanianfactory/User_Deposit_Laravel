<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Deposit extends Model
{
    protected $fillable = [
        'user_id',
        'balance',
    ];
}
