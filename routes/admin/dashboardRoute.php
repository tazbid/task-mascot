<?php

// use Illuminate\Support\Facades\Route;

use App\Http\Controllers\admin\Dashboard\DashboardController;
use Illuminate\Support\Facades\Route;

Route::post('/check-email', [DashboardController::class, 'checkEmail']);

Route::group(['middleware' => ['auth', 'checkUserStatus']], function () {
    //view  dashboard route admin
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/admin/users', [DashboardController::class, 'showUsersPage']);
    Route::view('admin/test','admin.test.test');

    Route::post('/admin/users', [DashboardController::class, 'usersViewDatatableAjax']);
});
