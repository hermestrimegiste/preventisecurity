<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreMedicalRecordRequest;
use App\Http\Requests\UpdateMedicalRecordRequest;
use App\Models\MedicalRecord;
use App\Models\Appointment;
use App\Models\Patient;

class MedicalRecordController extends Controller
{
    /**
     * Store a newly created medical record in storage.
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

    /**
     * Display the specified medical record.
     */
    public function show(MedicalRecord $medicalRecord)
    {
        $medicalRecord->load(['patient', 'appointment', 'doctor']);

        return response()->json($medicalRecord);
    }

    /**
     * Update the specified medical record in storage.
     */
    public function update(UpdateMedicalRecordRequest $request, MedicalRecord $medicalRecord)
    {
        $this->authorize('update', $medicalRecord);
        
        $medicalRecord->update($request->validated());
        $medicalRecord->load(['patient', 'appointment', 'doctor']);

        return response()->json($medicalRecord);
    }

    /**
     * Remove the specified medical record from storage.
     */
    public function destroy(MedicalRecord $medicalRecord)
    {
        $this->authorize('delete', $medicalRecord);

        $medicalRecord->delete();

        return response()->json(null, 204);
    }

    /**
     * Get medical records for a specific patient.
     */
    public function byPatient(Patient $patient)
    {
        $records = $patient->medicalRecords()
            ->with(['doctor', 'appointment'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return response()->json($records);
    }

    /**
     * Get upcoming and overdue follow-ups.
     */
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
