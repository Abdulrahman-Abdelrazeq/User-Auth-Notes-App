<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\Api\LoginController;
use App\Http\Controllers\Auth\Api\RegisterController;
// use App\Http\Controllers\Auth\Api\ForgotPasswordController;
// use App\Http\Controllers\Auth\Api\ResetPasswordController;
// use App\Http\Controllers\Auth\Api\VerificationController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\NoteController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;



// User Registration
Route::post('register', [RegisterController::class, 'register']);

// User Login
Route::post('login', [LoginController::class, 'login']);

// // User Logout
Route::middleware('auth:sanctum')->post('logout', [LoginController::class, 'logout']);

// // Password Reset Routes
// Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail']);
// Route::post('password/reset', [ResetPasswordController::class, 'reset']);

// // Email Verification Routes
// Route::middleware('auth:sanctum')->get('email/verify', [VerificationController::class, 'show'])->name('verification.notice');
// Route::middleware('auth:sanctum')->get('email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
// Route::middleware('auth:sanctum')->post('email/resend', [VerificationController::class, 'resend'])->name('verification.resend');






Route::middleware('auth:sanctum')->group(function () {
    // Email Verification Routes
    Route::get('/email/verify', function () {
        return response()->json(['message' => 'Verify your email address']);
    })->name('api.verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return response()->json(['message' => 'Email verified successfully']);
    })->middleware(['signed'])->name('api.verification.verify');

    Route::post('/email/resend', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return response()->json(['message' => 'Verification link resent']);
    })->middleware(['throttle:6,1'])->name('api.verification.resend');
});







// Profile Management
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);
});

// CRUD operations for notes
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/notes', NoteController::class)->names([
        'index' => 'api.notes.index',
        'create' => 'api.notes.create',
        'store' => 'api.notes.store',
        'show' => 'api.notes.show',
        'edit' => 'api.notes.edit',
        'update' => 'api.notes.update',
        'destroy' => 'api.notes.destroy',
    ]);
});
