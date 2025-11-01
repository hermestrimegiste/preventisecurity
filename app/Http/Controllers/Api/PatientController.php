<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Models\Patient;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Patients",
 *     description="Endpoints for managing patients"
 * )
 */

class PatientController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/patients",
     *     summary="List all patients",
     *     tags={"Patients"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Search term",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="gender",
     *         in="query",
     *         description="Filter by gender",
     *         required=false,
     *         @OA\Schema(type="string", enum={"male", "female", "other"})
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of patients",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Patient")
     *         )
     *     )
     * )
     */
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
        $this->authorize('delete patients');

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
