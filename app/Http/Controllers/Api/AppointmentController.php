<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the appointments.
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

    /**
     * List upcoming appointments.
     */
    public function upcoming()
    {
        $appointments = Appointment::with(['patient', 'doctor'])
            ->upcoming()
            ->paginate(20);

        return response()->json($appointments);
    }

    /**
     * List today's appointments.
     */
    public function today()
    {
        $appointments = Appointment::with(['patient', 'doctor'])
            ->today()
            ->orderBy('appointment_date')
            ->get();

        return response()->json($appointments);
    }

    /**
     * Get appointments for calendar view.
     */
    public function calendar(Request $request)
    {
        $startDate = $request->get('start', now()->startOfMonth());
        $endDate = $request->get('end', now()->endOfMonth());

        $appointments = Appointment::with(['patient', 'doctor'])
            ->betweenDates($startDate, $endDate)
            ->get();

        return response()->json($appointments);
    }

    /**
     * Store a newly created appointment in storage.
     */
    public function store(StoreAppointmentRequest $request)
    {
        $appointment = Appointment::create($request->validated());
        $appointment->load(['patient', 'doctor']);

        return response()->json($appointment, 201);
    }

    /**
     * Display the specified appointment.
     */
    public function show(Appointment $appointment)
    {
        $appointment->load(['patient', 'doctor', 'medicalRecord']);

        return response()->json($appointment);
    }

    /**
     * Update the specified appointment in storage.
     */
    public function update(UpdateAppointmentRequest $request, Appointment $appointment)
    {
        $this->authorize('update', $appointment);
        
        $appointment->update($request->validated());
        $appointment->load(['patient', 'doctor']);

        return response()->json($appointment);
    }

    /**
     * Remove the specified appointment from storage.
     */
    public function destroy(Appointment $appointment)
    {
        $this->authorize('delete', $appointment);

        $appointment->delete();

        return response()->json(null, 204);
    }

    /**
     * Cancel the specified appointment.
     */
    public function cancel(Appointment $appointment)
    {
        $this->authorize('cancel', $appointment);

        if (!$appointment->canBeCancelled()) {
            return response()->json([
                'message' => 'This appointment cannot be cancelled.'
            ], 422);
        }

        $appointment->cancel();

        return response()->json($appointment);
    }

    /**
     * Mark the specified appointment as completed.
     */
    public function complete(Appointment $appointment)
    {
        $this->authorize('complete', $appointment);
        
        if (!$appointment->canBeCompleted()) {
            return response()->json([
                'message' => 'This appointment cannot be marked as completed.'
            ], 422);
        }

        $appointment->markAsCompleted();

        return response()->json($appointment);
    }

    /**
     * Get upcoming appointments for a specific doctor.
     */
    public function byDoctor(User $doctor)
    {
        $appointments = Appointment::with('patient')
            ->forDoctor($doctor->id)
            ->upcoming()
            ->paginate(20);

        return response()->json($appointments);
    }
}
