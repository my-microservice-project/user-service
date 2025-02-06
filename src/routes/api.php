<?php

use App\Http\Controllers\V1\UserController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], function () {
    Route::group(['prefix' => 'users'], function () {
        Route::resource('/', UserController::class)->only(['index', 'store']);
        Route::post('/verify-credentials', [UserController::class, 'verifyCredentials']);
    });
});


