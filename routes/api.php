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

    // DatacomController Group
    Route::middleware("apidatacom")->group(function () {
        Route::post("ssh-load-pons/{ponid}", [\App\Http\Controllers\Api\DatacomController::class, "loadPons"])->name("api.ssh-load-pons");
        Route::post("ssh-discovery-pons-datacom", [\App\Http\Controllers\Api\DatacomController::class, "discoveryPonsDatacom"])->name("api.ssh-discovery-pons-datacom");
        //Route::post("ssh-load-pons-alarms/{ponid}", [\App\Http\Controllers\Api\DatacomController::class, "loadAlarmsInPons"])->name("api.ssh-load-pons-alarms");
    });

    // OPGController Group
    // Route::middleware("opg")->group(function () {
    //     Route::post("opg-get-alerts", [\App\Http\Controllers\Api\OPGController::class, "getAlertsBkp"])->name("api.get-alarms");
    //     //
    // });
});
