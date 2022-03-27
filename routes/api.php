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

// Bearer

// Route::post('/user', function (Request $request) {
//     return json_encode(["headers" => $request->headers]);
// });

Route::middleware('auth:sanctum')->post('/user', function (Request $request) {
    if (!checkNivel(auth()->user()->id, "read")) {
        return "erro de permissão";
    }
    return json_encode(["teste" => auth()->user()]);
});

Route::post('/login', [AuthController::class, "login"])->name("api.login");
