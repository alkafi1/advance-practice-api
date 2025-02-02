<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\User\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// protected routes
Route::middleware('auth:sanctum')->group(function () {
    // logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // user routes list
    // Route::get('/user', [AuthController::class, 'user']);

    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('user.list'); // List users Route::get('/', [UserController::class, 'index'])->name('user.list'); // List users
        Route::get('/{id}', [UserController::class, 'show'])->name('user.show'); // Show user details
        Route::put('/{id}', [UserController::class, 'update'])->name('user.update'); // Update user
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('user.delete'); // Delete user
    });
});
