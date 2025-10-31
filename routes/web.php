<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\WebPagesController;
use App\Http\Controllers\Api\User\DepositController;

Route::controller(WebPagesController::class)->group(function() {
    Route::get('/', 'home')->name('common.pages.home');
});
