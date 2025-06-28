<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GameController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Authentication routes (passwordless)
Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::get('/auth/user', [AuthController::class, 'user'])->middleware('auth:sanctum');

// Game routes
Route::get('/game/next-number', [GameController::class, 'nextNumber']);

Route::middleware(['auth'])->group(function () {
    Route::post('/game/validate-number', [GameController::class, 'validateNumber'])->middleware('auth:sanctum');
    Route::post('/game/new-game', [GameController::class, 'newGame'])->middleware('auth:sanctum');
    Route::post('/game/win', [GameController::class, 'win'])->middleware('auth:sanctum');
    Route::get('/game/leaderboard', [GameController::class, 'leaderboard'])->middleware('auth:sanctum');
});
