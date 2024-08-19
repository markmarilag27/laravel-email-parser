<?php

use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Auth\LogoutController;
use App\Http\Middleware\Guest;
use Illuminate\Support\Facades\Route;

/**
 ***********************************
 * Auth routes
 ***********************************
 */
Route::name('auth.')->prefix('auth')->group(function () {
    // Login
    Route::post('login', LoginController::class)->name('login')->middleware(Guest::class);
    // Logout
    Route::post('logout', LogoutController::class)->name('logout')->middleware('auth:sanctum');
});
