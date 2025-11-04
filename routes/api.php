<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\MedicalRecordController;
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

    // Patient Routes
    Route::prefix('patients')->group(function () {
        Route::get('/', [PatientController::class, 'index']);
        Route::post('/', [PatientController::class, 'store']);
        Route::get('/search', [PatientController::class, 'search']);
        Route::get('/{patient}', [PatientController::class, 'show']);
        Route::patch('/{patient}', [PatientController::class, 'update']);
        Route::delete('/{patient}', [PatientController::class, 'destroy']);
        Route::get('/{patient}/appointments', [PatientController::class, 'appointments']);
        Route::get('/{patient}/medical-records', [PatientController::class, 'medicalRecords']);
    });

    // Appointment Routes
    Route::prefix('appointments')->group(function () {
        Route::get('/', [AppointmentController::class, 'index']);
        Route::post('/', [AppointmentController::class, 'store']);
        Route::get('/upcoming', [AppointmentController::class, 'upcoming']);
        Route::get('/today', [AppointmentController::class, 'today']);
        Route::get('/calendar', [AppointmentController::class, 'calendar']);
        Route::get('/doctor/{doctor}', [AppointmentController::class, 'byDoctor']);
        Route::get('/{appointment}', [AppointmentController::class, 'show']);
        Route::patch('/{appointment}', [AppointmentController::class, 'update']);
        Route::delete('/{appointment}', [AppointmentController::class, 'destroy']);
        Route::patch('/{appointment}/cancel', [AppointmentController::class, 'cancel']);
        Route::patch('/{appointment}/complete', [AppointmentController::class, 'complete']);
    });

    // Medical Record Routes
    Route::prefix('medical-records')->group(function () {
        Route::post('/', [MedicalRecordController::class, 'store']);
        Route::get('/patient/{patient}', [MedicalRecordController::class, 'byPatient']);
        Route::get('/follow-ups', [MedicalRecordController::class, 'followUps']);
        Route::get('/{medicalRecord}', [MedicalRecordController::class, 'show']);
        Route::patch('/{medicalRecord}', [MedicalRecordController::class, 'update']);
        Route::delete('/{medicalRecord}', [MedicalRecordController::class, 'destroy']);
    });

    // Statistics & Dashboard (Admin and Doctor)
    Route::prefix('statistics')->group(function () {
        Route::get('/dashboard', function () {
            return response()->json([
                'total_patients' => \App\Models\Patient::count(),
                'total_appointments' => \App\Models\Appointment::count(),
                'appointments_today' => \App\Models\Appointment::today()->count(),
                'upcoming_appointments' => \App\Models\Appointment::upcoming()->count(),
                'completed_appointments' => \App\Models\Appointment::completed()->count(),
                'pending_follow_ups' => \App\Models\MedicalRecord::upcomingFollowUps()->count(),
            ]);
        });
    });
});
