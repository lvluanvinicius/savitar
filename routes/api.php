<?php


use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/// Route Login...
Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, "login"])->name("api.login");

Route::middleware('auth:sanctum')->group(function () {
    Route::post("ssh-load-pons/{ponid}", [\App\Http\Controllers\Api\DatacomController::class, "loadPons"]);
});
