<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Appointment::with(['patient', 'doctor']);

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('doctor_id')) {
            $query->forDoctor($request->doctor_id);
        }

        if ($request->has('date')) {
            $query->onDate($request->date);
        }

        $appointments = $query->orderBy('appointment_date')
            ->paginate(20);

        $doctors = User::role('doctor')
            ->whereHas('organizations', function ($q) {
                $q->where('organization_id', auth()->user()->current_organization_id);
            })
            ->get();

        return Inertia::render('Appointments/Index', [
            'appointments' => $appointments,
            'doctors' => $doctors,
            'filters' => $request->only(['status', 'doctor_id', 'date']),
        ]);
    }

    public function calendar(Request $request)
    {
        $startDate = $request->get('start', now()->startOfMonth());
        $endDate = $request->get('end', now()->endOfMonth());

        $appointments = Appointment::with(['patient', 'doctor'])
            ->betweenDates($startDate, $endDate)
            ->get();

        return Inertia::render('Appointments/Calendar', [
            'appointments' => $appointments,
        ]);
    }

    public function create()
    {
        $patients = Patient::orderBy('last_name')->orderBy('first_name')->get();

        $doctors = User::role('doctor')
            ->whereHas('organizations', function ($q) {
                $q->where('organization_id', auth()->user()->current_organization_id);
            })
            ->get();

        return Inertia::render('Appointments/Create', [
            'patients' => $patients,
            'doctors' => $doctors,
        ]);
    }

    public function store(StoreAppointmentRequest $request)
    {
        $appointment = Appointment::create($request->validated());

        return redirect()->route('appointments.show', $appointment)
            ->with('success', 'Appointment created successfully.');
    }

    public function show(Appointment $appointment)
    {
        $appointment->load(['patient', 'doctor', 'medicalRecord']);

        return Inertia::render('Appointments/Show', [
            'appointment' => $appointment,
        ]);
    }

    public function edit(Appointment $appointment)
    {
        $patients = Patient::orderBy('last_name')->orderBy('first_name')->get();

        $doctors = User::role('doctor')
            ->whereHas('organizations', function ($q) {
                $q->where('organization_id', auth()->user()->current_organization_id);
            })
            ->get();

        return Inertia::render('Appointments/Edit', [
            'appointment' => $appointment->load('patient', 'doctor'),
            'patients' => $patients,
            'doctors' => $doctors,
        ]);
    }

    public function update(UpdateAppointmentRequest $request, Appointment $appointment)
    {
        $appointment->update($request->validated());

        return redirect()->route('appointments.show', $appointment)
            ->with('success', 'Appointment updated successfully.');
    }

    public function destroy(Appointment $appointment)
    {
        $this->authorize('delete appointments');

        $appointment->delete();

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment deleted successfully.');
    }

    public function cancel(Appointment $appointment)
    {
        $this->authorize('cancel appointments');

        if (!$appointment->canBeCancelled()) {
            return back()->with('error', 'This appointment cannot be cancelled.');
        }

        $appointment->cancel();

        return back()->with('success', 'Appointment cancelled successfully.');
    }

    public function complete(Appointment $appointment)
    {
        if (!$appointment->canBeCompleted()) {
            return back()->with('error', 'This appointment cannot be marked as completed.');
        }

        $appointment->markAsCompleted();

        return redirect()->route('medical-records.create', ['appointment_id' => $appointment->id])
            ->with('success', 'Appointment completed. Please add medical record.');
    }

    public function byDoctor(User $doctor)
    {
        $appointments = Appointment::with('patient')
            ->forDoctor($doctor->id)
            ->upcoming()
            ->paginate(20);

        return Inertia::render('Appointments/ByDoctor', [
            'doctor' => $doctor,
            'appointments' => $appointments,
        ]);
    }
}
