<?php

namespace App\Http\Controllers\Api\Docs;

/**
 * @OA\Schema(
 *     schema="MedicalRecord",
 *     type="object",
 *     required={"patient_id", "appointment_id", "chief_complaint"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="organization_id", type="integer", example=1),
 *     @OA\Property(property="patient_id", type="integer", example=1),
 *     @OA\Property(property="appointment_id", type="integer", example=1, nullable=true),
 *     @OA\Property(property="doctor_id", type="integer", example=1),
 *     @OA\Property(property="chief_complaint", type="string", example="Headache and fever"),
 *     @OA\Property(property="diagnosis", type="string", example="Viral infection", nullable=true),
 *     @OA\Property(property="examination_notes", type="string", example="Patient presents with high fever and headache", nullable=true),
 *     @OA\Property(property="treatment_plan", type="string", example="Prescribed paracetamol and rest", nullable=true),
 *     @OA\Property(property="prescription", type="string", example="Paracetamol 500mg every 6 hours as needed", nullable=true),
 *     @OA\Property(property="lab_tests", type="string", example="CBC, COVID-19 test", nullable=true),
 *     @OA\Property(property="follow_up_instructions", type="string", example="Return if symptoms worsen", nullable=true),
 *     @OA\Property(property="follow_up_date", type="string", format="date", example="2023-02-01", nullable=true),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time"),
 *     @OA\Property(
 *         property="patient",
 *         ref="#/components/schemas/Patient",
 *         description="Patient details"
 *     ),
 *     @OA\Property(
 *         property="doctor",
 *         ref="#/components/schemas/User",
 *         description="Doctor details"
 *     ),
 *     @OA\Property(
 *         property="appointment",
 *         ref="#/components/schemas/Appointment",
 *         description="Related appointment",
 *         nullable=true
 *     )
 * )
 * 
 * @OA\Schema(
 *     schema="StoreMedicalRecordRequest",
 *     required={"patient_id", "appointment_id", "chief_complaint"},
 *     @OA\Property(property="patient_id", type="integer", example=1),
 *     @OA\Property(property="appointment_id", type="integer", example=1, nullable=true),
 *     @OA\Property(property="chief_complaint", type="string", example="Headache and fever", maxLength=1000),
 *     @OA\Property(property="diagnosis", type="string", example="Viral infection", maxLength=1000, nullable=true),
 *     @OA\Property(property="examination_notes", type="string", example="Patient presents with high fever and headache", maxLength=2000, nullable=true),
 *     @OA\Property(property="treatment_plan", type="string", example="Prescribed paracetamol and rest", maxLength=2000, nullable=true),
 *     @OA\Property(property="prescription", type="string", example="Paracetamol 500mg every 6 hours as needed", maxLength=2000, nullable=true),
 *     @OA\Property(property="lab_tests", type="string", example="CBC, COVID-19 test", maxLength=1000, nullable=true),
 *     @OA\Property(property="follow_up_instructions", type="string", example="Return if symptoms worsen", maxLength=1000, nullable=true),
 *     @OA\Property(property="follow_up_date", type="string", format="date", example="2023-02-01", nullable=true)
 * )
 * 
 * @OA\Schema(
 *     schema="UpdateMedicalRecordRequest",
 *     @OA\Property(property="chief_complaint", type="string", example="Headache and fever", maxLength=1000, nullable=true),
 *     @OA\Property(property="diagnosis", type="string", example="Viral infection", maxLength=1000, nullable=true),
 *     @OA\Property(property="examination_notes", type="string", example="Patient presents with high fever and headache", maxLength=2000, nullable=true),
 *     @OA\Property(property="treatment_plan", type="string", example="Prescribed paracetamol and rest", maxLength=2000, nullable=true),
 *     @OA\Property(property="prescription", type="string", example="Paracetamol 500mg every 6 hours as needed", maxLength=2000, nullable=true),
 *     @OA\Property(property="lab_tests", type="string", example="CBC, COVID-19 test", maxLength=1000, nullable=true),
 *     @OA\Property(property="follow_up_instructions", type="string", example="Return if symptoms worsen", maxLength=1000, nullable=true),
 *     @OA\Property(property="follow_up_date", type="string", format="date", example="2023-02-01", nullable=true)
 * )
 */
class MedicalRecordDoc
{
    // This class is used only for Swagger documentation
}
