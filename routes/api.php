<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LabelController;
use App\Http\Controllers\ReportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login']);
// Route Terproteksi (Harus pakai Token)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/reports', [ReportController::class, 'index']);
    Route::get('/reports/{id}', [ReportController::class, 'show']);
    Route::post('/reports', [ReportController::class, 'store']);
    Route::put('/reports/{id}', [ReportController::class, 'update']);
    Route::delete('/reports/{id}', [ReportController::class, 'destroy']);
    
    Route::get('/labels', [LabelController::class, 'index']);
    Route::get('/labels/{id}', [LabelController::class, 'show']);
    Route::post('/labels', [LabelController::class, 'store']);
    Route::put('/labels/{id}', [LabelController::class, 'update']);
    Route::delete('/labels/{id}', [LabelController::class, 'destroy']);


    
    Route::post('/logout', [AuthController::class, 'logout']);
});