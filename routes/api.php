<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\ProfileControlller;
/*Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
*/
Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [LoginController::class, 'register']);

Route::middleware(['auth:sanctum'])->group(function () {
    
    Route::get('/profile', [ProfileControlller::class, 'index']);

    Route::delete('/logout', [LoginController::class, 'logout']);
});