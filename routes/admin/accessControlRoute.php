<?php

use App\Http\Controllers\admin\AccessControl\AccessControlController;
// use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'checkUserStatus', 'role:super-admin|admin']], function () {

    //view route
    Route::get('access-control/roles', [AccessControlController::class, 'rolesView']);
    Route::get('access-control/users', [AccessControlController::class, 'usersView']);

    //internal route


    Route::post('access-control/user', [AccessControlController::class, 'usersDetailsAjax']);
    Route::post('access-control/user/activate', [AccessControlController::class, 'userActivateAjax']);
    Route::post('access-control/user/deactivate', [AccessControlController::class, 'userDeactivateAjax']);
    Route::post('access-control/user/delete', [AccessControlController::class, 'userDeleteAjax']);
    Route::post('access-control/user/setrole', [AccessControlController::class, 'usersSyncRoleAjax']);
    Route::post('access-control/users', [AccessControlController::class, 'usersViewDatatableAjax']);

    //download
    //export all user with roles
    Route::post('access-control/users/download',[AccessControlController::class,'userDownload']);


});

// Route::get('/6251/bk/destroy', function () {

//     Artisan::call('migrate:reset');

//     dd("Destroyed in seconds");

// });

