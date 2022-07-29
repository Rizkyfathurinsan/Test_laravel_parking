<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::middleware('auth', 'CheckLevel:admin')->group(function () {

    // Route::get('/user', [App\Http\Controllers\UserController::class, 'index'])->name('user.index');
    Route::get('exportvehicle/', [App\Http\Controllers\VehicleController::class, 'export'])->name('exportvehicle');


});

Route::middleware('auth', 'CheckLevel:admin,user')->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    // Route::get('/user', [App\Http\Controllers\UserController::class, 'index'])->name('user.index');
    Route::resource('/vehicles', App\Http\Controllers\VehicleController::class);
    Route::post('exittvehicle/', [App\Http\Controllers\VehicleController::class, 'exit'])->name('exitvehicle');
 

});
