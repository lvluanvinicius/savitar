<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ {
    AuthController
};

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

Route::middleware('auth:sanctum')->post('/user', function (Request $request) {
    if (!checkNivel(auth()->user()->id, "*") && !checkNivel(auth()->user()->id, "read")) {
        return "erro de permissão";
    }
    return json_encode(["teste" => auth()->user()]);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post("login-ssh", function (Request $request) {
        return $request->all();
    });
});


Route::post('/login', [AuthController::class, "login"])->name("api.login");








