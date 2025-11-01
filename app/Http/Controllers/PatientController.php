<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Models\Patient;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $query = Patient::with(['latestAppointment', 'nextAppointment']);

        if ($request->has('search')) {
            $query->search($request->search);
        }

        if ($request->has('gender')) {
            $query->byGender($request->gender);
        }

        $patients = $query->orderBy('last_name')
            ->orderBy('first_name')
            ->paginate(20);

        return Inertia::render('Patients/Index', [
            'patients' => $patients,
            'filters' => $request->only(['search', 'gender']),
        ]);
    }

    public function create()
    {
        return Inertia::render('Patients/Create');
    }

    public function store(StorePatientRequest $request)
    {
        $patient = Patient::create($request->validated());

        return redirect()->route('patients.show', $patient)
            ->with('success', 'Patient created successfully.');
    }

    public function show(Patient $patient)
    {
        $patient->load([
            'appointments' => function ($query) {
                $query->with('doctor')->latest('appointment_date')->limit(10);
            },
            'medicalRecords' => function ($query) {
                $query->with('doctor')->latest()->limit(5);
            },
            'nextAppointment.doctor',
        ]);

        return Inertia::render('Patients/Show', [
            'patient' => $patient,
        ]);
    }

    public function edit(Patient $patient)
    {
        return Inertia::render('Patients/Edit', [
            'patient' => $patient,
        ]);
    }

    public function update(UpdatePatientRequest $request, Patient $patient)
    {
        $patient->update($request->validated());

        return redirect()->route('patients.show', $patient)
            ->with('success', 'Patient updated successfully.');
    }

    public function destroy(Patient $patient)
    {
        $this->authorize('delete patients');

        $patient->delete();

        return redirect()->route('patients.index')
            ->with('success', 'Patient deleted successfully.');
    }

    public function appointments(Patient $patient)
    {
        $appointments = $patient->appointments()
            ->with('doctor')
            ->orderBy('appointment_date', 'desc')
            ->paginate(15);

        return Inertia::render('Patients/Appointments', [
            'patient' => $patient,
            'appointments' => $appointments,
        ]);
    }

    public function medicalRecords(Patient $patient)
    {
        $records = $patient->medicalRecords()
            ->with(['doctor', 'appointment'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return Inertia::render('Patients/MedicalRecords', [
            'patient' => $patient,
            'records' => $records,
        ]);
    }
}
