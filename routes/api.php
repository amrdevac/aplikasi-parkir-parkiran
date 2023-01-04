<?php

use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\ParkingController;
use App\Http\Controllers\ParkirController;
use App\Http\Controllers\VerifyController;
use Illuminate\Http\Request;
use Illuminate\Routing\RouteGroup;
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



Route::middleware('auth:sanctum')->group(function () {
    Route::prefix("parkir")->group(function () {
        Route::get("/", [ParkingController::class, "index"]);
        Route::get("/with-limit", [ParkingController::class, "indexWithLimit"]);
        Route::post("/", [ParkingController::class, "store"]);
        Route::post("/export/excel", [ParkingController::class, "exportExcel"]);
        Route::post("/payment/cash", [ParkingController::class, "paymentCash"]);
        Route::post("/detail", [ParkingController::class, "detail"]);
        Route::post("/verify/uuid", [ParkingController::class, "showUniqueUUID"]);
    });

    Route::prefix("karyawan")->group(function () {
        Route::get("/", [KaryawanController::class, "index"]);
        Route::put("/", [KaryawanController::class, "update"]);
        Route::post("/", [KaryawanController::class, "store"]);
        Route::delete("/", [KaryawanController::class, "delete"]);
    });

    Route::prefix("verify")->group(function () {
        Route::post("/password", [VerifyController::class, "store"]);
    });
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
