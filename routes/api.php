<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\LocationSettingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Auth routes
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // Attendance routes for all users
    Route::post('/check-in', [AttendanceController::class, 'checkIn']);
    Route::post('/check-out', [AttendanceController::class, 'checkOut']);
    Route::get('/my-attendances', [AttendanceController::class, 'getMyAttendances']);

    // Location settings (read only for all users)
    Route::get('/location-setting', [LocationSettingController::class, 'getCurrentSetting']);

    // Admin only routes
    Route::middleware('admin')->group(function () {
        // Users management
        Route::get('/users', [UserController::class, 'index']);
        Route::get('/users/{user}', [UserController::class, 'show']);
        Route::get('/guru-list', [UserController::class, 'getGuruList']);
        
        // Attendances management
        Route::get('/attendances', [AttendanceController::class, 'getAllAttendances']);
        Route::get('/attendance-report', [AttendanceController::class, 'getAttendanceReport']);
        Route::get('/export-attendances', [AttendanceController::class, 'exportExcel']);
        
        // Location settings management
        Route::post('/location-setting', [LocationSettingController::class, 'updateSetting']);
        Route::get('/location-setting-history', [LocationSettingController::class, 'getSettingHistory']);
    });
});

// Fallback for undefined routes
Route::fallback(function () {
    return response()->json([
        'message' => 'API route not found'
    ], 404);
});