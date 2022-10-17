<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\UserController;
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

Route::get('/', [AuthController::class, 'index'])->name('login.page');

Route::post('/login/auth', [AuthController::class, 'do'])->name('login.do');

Route::middleware("auth")->prefix("admin")->as("admin.")->group(function () {
    Route::get("/home", [HomeController::class, 'index'])->name("home.page");
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::prefix('users')->as("users.")->group(function () {
        Route::get('/', [UserController::class, 'index'])->name("list");
    });
});
