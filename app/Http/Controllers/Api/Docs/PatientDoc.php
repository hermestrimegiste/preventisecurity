<?php

namespace App\Http\Controllers\Api\Docs;

/**
 * @OA\Schema(
 *     schema="Patient",
 *     type="object",
 *     required={"first_name", "last_name", "date_of_birth", "gender", "phone"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="organization_id", type="integer", example=1),
 *     @OA\Property(property="first_name", type="string", example="John"),
 *     @OA\Property(property="last_name", type="string", example="Doe"),
 *     @OA\Property(property="date_of_birth", type="string", format="date", example="1990-01-15"),
 *     @OA\Property(property="gender", type="string", enum={"male", "female", "other"}, example="male"),
 *     @OA\Property(property="email", type="string", format="email", example="john.doe@example.com", nullable=true),
 *     @OA\Property(property="phone", type="string", example="+1234567890"),
 *     @OA\Property(property="address", type="string", example="123 Main St, City", nullable=true),
 *     @OA\Property(property="emergency_contact_name", type="string", example="Jane Doe", nullable=true),
 *     @OA\Property(property="emergency_contact_phone", type="string", example="+1987654321", nullable=true),
 *     @OA\Property(property="medical_history", type="string", example="Hypertension, Diabetes", nullable=true),
 *     @OA\Property(property="allergies", type="string", example="Penicillin, Nuts", nullable=true),
 *     @OA\Property(property="blood_group", type="string", example="A+", nullable=true),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time"),
 *     @OA\Property(property="deleted_at", type="string", format="date-time", nullable=true)
 * )
 * 
 * @OA\Schema(
 *     schema="StorePatientRequest",
 *     required={"first_name", "last_name", "date_of_birth", "gender", "phone"},
 *     @OA\Property(property="first_name", type="string", example="John"),
 *     @OA\Property(property="last_name", type="string", example="Doe"),
 *     @OA\Property(property="date_of_birth", type="string", format="date", example="1990-01-15"),
 *     @OA\Property(property="gender", type="string", enum={"male", "female", "other"}, example="male"),
 *     @OA\Property(property="email", type="string", format="email", example="john.doe@example.com", nullable=true),
 *     @OA\Property(property="phone", type="string", example="+1234567890"),
 *     @OA\Property(property="address", type="string", example="123 Main St, City", nullable=true),
 *     @OA\Property(property="emergency_contact_name", type="string", example="Jane Doe", nullable=true),
 *     @OA\Property(property="emergency_contact_phone", type="string", example="+1987654321", nullable=true),
 *     @OA\Property(property="medical_history", type="string", example="Hypertension, Diabetes", nullable=true),
 *     @OA\Property(property="allergies", type="string", example="Penicillin, Nuts", nullable=true),
 *     @OA\Property(property="blood_group", type="string", example="A+", nullable=true)
 * )
 */
class PatientDoc
{
    // This class is used only for Swagger documentation
}
