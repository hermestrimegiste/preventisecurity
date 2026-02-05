<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\AssessmentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashboardController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Index', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
})->name('home');

// Dashboard (authenticated)
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

// Public Assessment Routes (no auth required)
Route::prefix('assessment')->group(function () {
    Route::get('/start', [AssessmentController::class, 'start'])->name('assessment.start');
    Route::post('/start', [AssessmentController::class, 'store'])->name('assessment.store');
    Route::get('/{token}/form', [AssessmentController::class, 'form'])->name('assessment.form');
    Route::get('/{token}/resume', [AssessmentController::class, 'resume'])->name('assessment.resume');
    Route::post('/{assessment}/answer', [AssessmentController::class, 'saveAnswer'])->name('assessment.answer');
    Route::post('/{assessment}/submit', [AssessmentController::class, 'submit'])->name('assessment.submit');
    Route::get('/{assessment}/complete', [AssessmentController::class, 'complete'])->name('assessment.complete');
});

// Public Report Shared Link (no auth required)
Route::get('/r/{token}', [ReportController::class, 'shared'])->name('report.shared');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Report Management
    Route::prefix('reports')->group(function () {
        Route::get('/{assessment}', [ReportController::class, 'show'])->name('reports.show');
        Route::post('/{assessment}/generate', [ReportController::class, 'generate'])->name('reports.generate');
        Route::post('/{assessment}/share', [ReportController::class, 'share'])->name('reports.share');
        Route::get('/{assessment}/pdf', [ReportController::class, 'pdf'])->name('reports.pdf');
    });

    // Organization Switching
    Route::post('/organization/switch/{organization}', [OrganizationController::class, 'switch'])
        ->name('organization.switch');

    // Organization Management (Admin only)
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/organization/settings', [OrganizationController::class, 'settings'])
            ->name('organization.settings');
        Route::patch('/organization/settings', [OrganizationController::class, 'updateSettings'])
            ->name('organization.update-settings');
        Route::post('/organization/invite', [OrganizationController::class, 'invite'])
            ->name('organization.invite');
        Route::get('/organization/members', [OrganizationController::class, 'members'])
            ->name('organization.members');
        Route::delete('/organization/members/{user}', [OrganizationController::class, 'removeMember'])
            ->name('organization.remove-member');
    });
});

require __DIR__.'/auth.php';
