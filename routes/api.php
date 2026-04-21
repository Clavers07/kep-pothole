<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Xml\Report;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login']);
// Route Terproteksi (Harus pakai Token)
Route::middleware('auth:sanctum')->group(function () {
   Route::post('/reports', [ReportController::class, 'store']);
   Route::put('/reports/{id}', [ReportController::class, 'update']);
   Route::delete('/reports/{id}', [ReportController::class, 'destroy']);


    
    Route::post('/logout', [AuthController::class, 'logout']);
});