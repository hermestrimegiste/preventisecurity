<?php

namespace App\Http\Controllers\Api\Docs;

/**
 * @OA\Schema(
 *     schema="Appointment",
 *     type="object",
 *     required={"patient_id", "doctor_id", "appointment_date", "duration_minutes"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="organization_id", type="integer", example=1),
 *     @OA\Property(property="patient_id", type="integer", example=1),
 *     @OA\Property(property="doctor_id", type="integer", example=1),
 *     @OA\Property(property="appointment_date", type="string", format="date-time", example="2023-01-01 14:00:00"),
 *     @OA\Property(property="duration_minutes", type="integer", example=30),
 *     @OA\Property(property="status", type="string", enum={"scheduled", "completed", "cancelled"}, example="scheduled"),
 *     @OA\Property(property="reason", type="string", example="Routine checkup", nullable=true),
 *     @OA\Property(property="notes", type="string", example="Patient has allergies to penicillin", nullable=true),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time"),
 *     @OA\Property(property="deleted_at", type="string", format="date-time", nullable=true),
 *     @OA\Property(
 *         property="patient",
 *         ref="#/components/schemas/Patient",
 *         description="Patient details"
 *     ),
 *     @OA\Property(
 *         property="doctor",
 *         ref="#/components/schemas/User",
 *         description="Doctor details"
 *     )
 * )
 * 
 * @OA\Schema(
 *     schema="StoreAppointmentRequest",
 *     required={"patient_id", "doctor_id", "appointment_date", "duration_minutes"},
 *     @OA\Property(property="patient_id", type="integer", example=1),
 *     @OA\Property(property="doctor_id", type="integer", example=1),
 *     @OA\Property(property="appointment_date", type="string", format="date-time", example="2023-01-01 14:00:00"),
 *     @OA\Property(property="duration_minutes", type="integer", example=30, minimum=15, maximum=240),
 *     @OA\Property(property="status", type="string", enum={"scheduled", "completed", "cancelled"}, example="scheduled"),
 *     @OA\Property(property="reason", type="string", example="Routine checkup", maxLength=255, nullable=true),
 *     @OA\Property(property="notes", type="string", example="Patient has allergies to penicillin", maxLength=1000, nullable=true)
 * )
 * 
 * @OA\Schema(
 *     schema="UpdateAppointmentRequest",
 *     @OA\Property(property="patient_id", type="integer", example=1, nullable=true),
 *     @OA\Property(property="doctor_id", type="integer", example=1, nullable=true),
 *     @OA\Property(property="appointment_date", type="string", format="date-time", example="2023-01-01 14:00:00", nullable=true),
 *     @OA\Property(property="duration_minutes", type="integer", example=30, minimum=15, maximum=240, nullable=true),
 *     @OA\Property(property="status", type="string", enum={"scheduled", "completed", "cancelled"}, example="completed", nullable=true),
 *     @OA\Property(property="reason", type="string", example="Routine checkup", maxLength=255, nullable=true),
 *     @OA\Property(property="notes", type="string", example="Patient has allergies to penicillin", maxLength=1000, nullable=true)
 * )
 */
class AppointmentDoc
{
    // This class is used only for Swagger documentation
}
