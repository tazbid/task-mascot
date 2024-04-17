<?php

use App\Http\Controllers\admin\Dashboard\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Auth::routes();

// Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/verify',function() {
    return view('auth.verify');
});
// Route::get('/login', [LoginController::class, 'showLoginForm']);

Route::group(['middleware' => ['auth','checkUserStatus']], function () {
    Route::get('/',function() {
        // return view('welcome');
        return Redirect::to('/admin/dashboard')->send();
    });
    Route::get('/home',function() {
        // return view('welcome');
        return Redirect::to('/admin/dashboard')->send();
    });
});

Route::get('/',function() {
    // return view('welcome');
    return Redirect::to('/login')->send();
});




//dashboard
include "admin/dashboardRoute.php";

//access control
include "admin/accessControlRoute.php";

//customer route
include "admin/customerRoute.php";


//publicSubmissionRoute

// //report route
// include "admin/reportRoute.php";

// //status route
// include "admin/statusRoute.php";

// //home
// include "admin/homeRoute.php";


