<?php

use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->prefix('attendance')->controller(AttendanceController::class)->group(function () {
    Route::post('/in', 'clockIn');
    Route::patch('/out', 'clockOut');
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// contoh protected route
Route::get('/profile', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
