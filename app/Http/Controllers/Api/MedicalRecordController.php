<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreMedicalRecordRequest;
use App\Http\Requests\UpdateMedicalRecordRequest;
use App\Models\MedicalRecord;
use App\Models\Appointment;
use App\Models\Patient;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Medical Records",
 *     description="Endpoints for managing medical records"
 * )
 */

class MedicalRecordController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/medical-records",
     *     summary="Create a new medical record",
     *     tags={"Medical Records"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreMedicalRecordRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Medical record created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/MedicalRecord")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function store(StoreMedicalRecordRequest $request)
    {
        $data = $request->validated();
        $data['doctor_id'] = auth()->id();

        $record = MedicalRecord::create($data);

        $appointment = Appointment::find($data['appointment_id']);
        if ($appointment && $appointment->status === 'scheduled') {
            $appointment->markAsCompleted();
        }

        $record->load(['patient', 'appointment', 'doctor']);

        return response()->json($record, 201);
    }

    public function show(MedicalRecord $medicalRecord)
    {
        $medicalRecord->load(['patient', 'appointment', 'doctor']);

        return response()->json($medicalRecord);
    }

    public function update(UpdateMedicalRecordRequest $request, MedicalRecord $medicalRecord)
    {
        $medicalRecord->update($request->validated());
        $medicalRecord->load(['patient', 'appointment', 'doctor']);

        return response()->json($medicalRecord);
    }

    public function destroy(MedicalRecord $medicalRecord)
    {
        $this->authorize('delete medical records');

        $medicalRecord->delete();

        return response()->json(null, 204);
    }

    public function byPatient(Patient $patient)
    {
        $records = $patient->medicalRecords()
            ->with(['doctor', 'appointment'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return response()->json($records);
    }

    public function followUps()
    {
        $upcoming = MedicalRecord::with(['patient', 'doctor'])
            ->upcomingFollowUps()
            ->paginate(20);

        $overdue = MedicalRecord::with(['patient', 'doctor'])
            ->overdueFollowUps()
            ->paginate(20);

        return response()->json([
            'upcoming' => $upcoming,
            'overdue' => $overdue,
        ]);
    }
}
