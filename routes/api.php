<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AttendanceController;

Route::post('/login', [AuthController::class, 'login']);
Route::get('/users', [AuthController::class, 'users']);
Route::post('/checkin', [AttendanceController::class, 'checkin']);
Route::post('/checkout', [AttendanceController::class, 'checkout']);
Route::get('/attendance', [AttendanceController::class, 'list']);
