<?php

use App\Http\Controllers\admin\customer\CustomerController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth', 'checkUserStatus']], function () {
    Route::get('profile', [CustomerController::class, 'adminProfileView']);

    //internal routs
    Route::post('customer/update', [CustomerController::class, 'customerUpdateAjax']);
    Route::post('customer/update/password', [CustomerController::class, 'customerUpdatePasswordAjax']);
    //download user avatar
    Route::get('download/avatar/{id}', [CustomerController::class, 'downloadAvatar']);
    Route::get('download/verification/{id}', [CustomerController::class, 'downloadVerification']);
});

Route::group(['middleware' => ['auth']], function () {
    Route::post('verify/code', [CustomerController::class, 'verifyCode']);
});
