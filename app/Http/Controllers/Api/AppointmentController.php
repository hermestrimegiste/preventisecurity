<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Appointments",
 *     description="Endpoints for managing appointments"
 * )
 */

class AppointmentController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/appointments",
     *     summary="List all appointments",
     *     tags={"Appointments"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="status",
     *         in="query",
     *         description="Filter by status",
     *         required=false,
     *         @OA\Schema(type="string", enum={"scheduled", "completed", "cancelled"})
     *     ),
     *     @OA\Parameter(
     *         name="doctor_id",
     *         in="query",
     *         description="Filter by doctor ID",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="date",
     *         in="query",
     *         description="Filter by date (YYYY-MM-DD)",
     *         required=false,
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of appointments",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Appointment")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     )
     * )
     */
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
            ->paginate($request->get('per_page', 20));

        return response()->json($appointments);
    }

    public function upcoming()
    {
        $appointments = Appointment::with(['patient', 'doctor'])
            ->upcoming()
            ->paginate(20);

        return response()->json($appointments);
    }

    public function today()
    {
        $appointments = Appointment::with(['patient', 'doctor'])
            ->today()
            ->orderBy('appointment_date')
            ->get();

        return response()->json($appointments);
    }

    public function calendar(Request $request)
    {
        $startDate = $request->get('start', now()->startOfMonth());
        $endDate = $request->get('end', now()->endOfMonth());

        $appointments = Appointment::with(['patient', 'doctor'])
            ->betweenDates($startDate, $endDate)
            ->get();

        return response()->json($appointments);
    }

    public function store(StoreAppointmentRequest $request)
    {
        $appointment = Appointment::create($request->validated());
        $appointment->load(['patient', 'doctor']);

        return response()->json($appointment, 201);
    }

    public function show(Appointment $appointment)
    {
        $appointment->load(['patient', 'doctor', 'medicalRecord']);

        return response()->json($appointment);
    }

    public function update(UpdateAppointmentRequest $request, Appointment $appointment)
    {
        $appointment->update($request->validated());
        $appointment->load(['patient', 'doctor']);

        return response()->json($appointment);
    }

    public function destroy(Appointment $appointment)
    {
        $this->authorize('delete appointments');

        $appointment->delete();

        return response()->json(null, 204);
    }

    public function cancel(Appointment $appointment)
    {
        $this->authorize('cancel appointments');

        if (!$appointment->canBeCancelled()) {
            return response()->json([
                'message' => 'This appointment cannot be cancelled.'
            ], 422);
        }

        $appointment->cancel();

        return response()->json($appointment);
    }

    public function complete(Appointment $appointment)
    {
        if (!$appointment->canBeCompleted()) {
            return response()->json([
                'message' => 'This appointment cannot be marked as completed.'
            ], 422);
        }

        $appointment->markAsCompleted();

        return response()->json($appointment);
    }

    public function byDoctor(User $doctor)
    {
        $appointments = Appointment::with('patient')
            ->forDoctor($doctor->id)
            ->upcoming()
            ->paginate(20);

        return response()->json($appointments);
    }
}
