<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\ProfileControlller;
use App\Http\Controllers\Api\TransactionController;

Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [LoginController::class, 'register']);

Route::middleware(['auth:sanctum'])->group(function () {
    
    Route::get('/profile', [ProfileControlller::class, 'index']);

    Route::post('/deposit', [TransactionController::class, 'deposit']);
    Route::post('/debit', [TransactionController::class, 'debit']);

    Route::delete('/logout', [LoginController::class, 'logout']);
});