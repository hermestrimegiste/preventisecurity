<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OrganizationController;
use App\Http\Controllers\Api\AuthController;

// Public routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Protected routes
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user()->load(['currentOrganization', 'organizations', 'roles']);
});

Route::middleware(['auth:sanctum'])->group(function () {

    // Organization Routes
    Route::prefix('organizations')->group(function () {
        Route::get('/', [OrganizationController::class, 'index']);
        Route::get('/current', [OrganizationController::class, 'current']);
        Route::post('/switch/{organization}', [OrganizationController::class, 'switch']);
        Route::get('/{organization}', [OrganizationController::class, 'show']);

        // Admin only
        Route::middleware(['role:admin'])->group(function () {
            Route::post('/', [OrganizationController::class, 'store']);
            Route::patch('/{organization}', [OrganizationController::class, 'update']);
            Route::delete('/{organization}', [OrganizationController::class, 'destroy']);
        });
    });
});
