<?php

declare(strict_types=1);

use App\Http\Controllers\Api\AiController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\InvitationController;
use App\Http\Controllers\Api\MediaController;
use App\Http\Controllers\Api\RsvpController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes — consumed by the DavetKart React SPA (axios, Bearer token)
|--------------------------------------------------------------------------
*/

Route::prefix('auth')->group(function (): void {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth:sanctum')->group(function (): void {
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    // Invitation — one invitation per account; POST and PUT both upsert,
    // matching the frontend persistence boundary (save whole object).
    Route::get('/invitations', [InvitationController::class, 'show']);
    Route::match(['post', 'put'], '/invitations', [InvitationController::class, 'save']);

    // RSVP (LCV)
    Route::get('/rsvps', [RsvpController::class, 'index']);
    Route::post('/rsvps', [RsvpController::class, 'store']);
    Route::delete('/rsvps/{id}', [RsvpController::class, 'destroy'])->whereNumber('id');

    // Media upload (gallery photos, RSVP guest photos/videos)
    Route::post('/media/upload', [MediaController::class, 'upload']);

    // AI proxy — keeps the GenAI API key server-side.
    Route::post('/ai/generate', [AiController::class, 'generate']);
});
