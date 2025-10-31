<?php

namespace App\Models\User;

use App\Models\User\DepositActions;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function deposit(): HasOne
    {
        return $this->hasOne(Deposit::class, 'user_id');
    }

    public function sentDepositActions(): HasMany
    {
        return $this->hasMany(DepositActions::class, 'from_user_id');
    }

    public function receivedDepositActions(): HasMany
    {
        return $this->hasMany(DepositActions::class, 'to_user_id');
    }

    public function allDepositActions()
    {
        return DepositActions::where(function($query) {
            $query->where('from_user_id', $this->id)
                  ->orWhere('to_user_id', $this->id);
        });
    }
}
