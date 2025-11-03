<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Models\Patient;
use Illuminate\Http\Request;

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
            ->paginate($request->get('per_page', 20));

        return response()->json($patients);
    }

    public function search(Request $request)
    {
        $request->validate([
            'q' => 'required|string|min:2',
        ]);

        $query = Patient::query();

        if ($request->has('q')) {
            $query->search($request->q);
        }

        $patients = $query->orderBy('last_name')
            ->orderBy('first_name')
            ->limit(10)
            ->get();

        return response()->json($patients);
    }

    public function store(StorePatientRequest $request)
    {
        $patient = Patient::create($request->validated());

        return response()->json($patient, 201);
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

        return response()->json($patient);
    }

    public function update(UpdatePatientRequest $request, Patient $patient)
    {
        $patient->update($request->validated());

        return response()->json($patient);
    }

    public function destroy(Patient $patient)
    {
        $this->authorize('delete', $patient);

        $patient->delete();

        return response()->json(null, 204);
    }

    public function appointments(Patient $patient)
    {
        $appointments = $patient->appointments()
            ->with('doctor')
            ->orderBy('appointment_date', 'desc')
            ->paginate(15);

        return response()->json($appointments);
    }

    public function medicalRecords(Patient $patient)
    {
        $records = $patient->medicalRecords()
            ->with(['doctor', 'appointment'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return response()->json($records);
    }
}
