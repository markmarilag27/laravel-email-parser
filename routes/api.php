<?php

use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Auth\LogoutController;
use App\Http\Controllers\API\SuccessfulEmailController;
use App\Http\Middleware\Guest;
use Illuminate\Support\Facades\Route;

/**
 ***********************************
 * Auth routes
 ***********************************
 */
Route::prefix('auth')->group(function () {
    // Login
    Route::post('login', LoginController::class)->name('login')->middleware(Guest::class);
    // Logout
    Route::post('logout', LogoutController::class)->name('logout')->middleware('auth:sanctum');
});

/**
 ***********************************
 * Successful emails routes
 ***********************************
 */
Route::middleware('auth:sanctum')
    ->name('successfulEmails.')
    ->prefix('successful-emails')->group(function () {
        // all records
        Route::get('/', [SuccessfulEmailController::class, 'index'])->name('index');
        // create a record
        Route::post('/', [SuccessfulEmailController::class, 'store'])->name('store');
        // get 1 record
        Route::get('{source}', [SuccessfulEmailController::class, 'show'])->name('show');
        // update record
        Route::put('{source}', [SuccessfulEmailController::class, 'update'])->name('update');
        // soft delete record
        Route::delete('{source}', [SuccessfulEmailController::class, 'destroy'])->name('destroy');
    });
