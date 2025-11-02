<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\OrganizationController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Models\Patient;
use App\Models\Appointment;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Index', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        //'laravelVersion' => Application::VERSION,
        //'phpVersion' => PHP_VERSION,
    ]) ;
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard', [
        'stats' => [
            'total_patients' => Patient::count(),
            'appointments_today' => Appointment::whereDate('appointment_date', today())->count(),
            'upcoming_appointments' => Appointment::where('appointment_date', '>=', now())->count(),
            'completed_this_week' => Appointment::where('status', 'completed')
                ->whereBetween('appointment_date', [now()->startOfWeek(), now()->endOfWeek()])
                ->count(),
        ],
        'todayAppointments' => Appointment::with(['patient', 'doctor'])
            ->whereDate('appointment_date', today())
            ->orderBy('appointment_date')
            ->get(),
        'upcomingAppointments' => Appointment::with(['patient', 'doctor'])
            ->where('appointment_date', '>=', now())
            ->orderBy('appointment_date')
            ->take(5)
            ->get(),
        'recentPatients' => Patient::where('created_at', '>=', now()->subDays(7))
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get(),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Organization Switching
    Route::post('/organization/switch/{organization}', [OrganizationController::class, 'switch'])
        ->name('organization.switch');

    // Patients Routes
    Route::resource('patients', PatientController::class);
    Route::get('/patients/{patient}/appointments', [PatientController::class, 'appointments'])
        ->name('patients.appointments');
    Route::get('/patients/{patient}/medical-records', [PatientController::class, 'medicalRecords'])
        ->name('patients.medical-records');

    // Appointments Routes
    Route::resource('appointments', AppointmentController::class);
    Route::get('/appointments/calendar', [AppointmentController::class, 'calendar'])
        ->name('appointments.calendar');
    Route::patch('/appointments/{appointment}/cancel', [AppointmentController::class, 'cancel'])
        ->name('appointments.cancel');
    Route::patch('/appointments/{appointment}/complete', [AppointmentController::class, 'complete'])
        ->name('appointments.complete');
    Route::get('/appointments/doctor/{doctor}', [AppointmentController::class, 'byDoctor'])
        ->name('appointments.by-doctor');

    // Medical Records Routes
    Route::resource('medical-records', MedicalRecordController::class)
        ->except(['index']);
    Route::get('/medical-records/patient/{patient}', [MedicalRecordController::class, 'byPatient'])
        ->name('medical-records.by-patient');
    Route::get('/medical-records/follow-ups', [MedicalRecordController::class, 'followUps'])
        ->name('medical-records.follow-ups');

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
