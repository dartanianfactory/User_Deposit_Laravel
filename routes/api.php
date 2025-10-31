<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\User\ApiAuthController;
use App\Http\Controllers\Api\User\ApiDepositController;

Route::controller(ApiDepositController::class)->group(function() {
    //for testing
});

Route::middleware('guest')->group(function() {
    Route::controller(ApiAuthController::class)->group(function() {
        Route::post('/user/login', 'login')->name('user.actions.login');
    });
});

Route::middleware('auth:sanctum')->group(function() {
    Route::controller(ApiAuthController::class)->group(function() {
        Route::post('/user/logout', 'logout')->name('user.actions.logout');
    });

    Route::controller(ApiDepositController::class)->group(function() {
        Route::post('/user/bank/deposit', 'deposit')->name('user.actions.deposit');
        Route::post('/user/bank/withdraw', 'withdraw')->name('user.actions.withdraw');
        Route::post('/user/bank/transfer', 'transfer')->name('user.actions.transfer');
        Route::get('/user/bank/balance/{user_id}', 'balance')->name('user.actions.balance');
    });
});
