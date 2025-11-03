<?php

namespace App\Http\Controllers\Api\Docs;

use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Appointment",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="patient_id", type="integer", example=1),
 *     @OA\Property(property="doctor_id", type="integer", example=1),
 *     @OA\Property(property="appointment_date", type="string", format="date-time"),
 *     @OA\Property(property="status", type="string", example="scheduled"),
 *     @OA\Property(property="reason", type="string", nullable=true),
 *     @OA\Property(property="notes", type="string", nullable=true),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time"),
 *     @OA\Property(
 *         property="patient",
 *         ref="#/components/schemas/User"
 *     ),
 *     @OA\Property(
 *         property="doctor",
 *         ref="#/components/schemas/User"
 *     )
 * )
 *
 * @OA\Schema(
 *     schema="StoreAppointmentRequest",
 *     type="object",
 *     required={"patient_id", "doctor_id", "appointment_date"},
 *     @OA\Property(property="patient_id", type="integer", example=1),
 *     @OA\Property(property="doctor_id", type="integer", example=1),
 *     @OA\Property(property="appointment_date", type="string", format="date-time"),
 *     @OA\Property(property="reason", type="string", nullable=true),
 *     @OA\Property(property="notes", type="string", nullable=true)
 * )
 *
 * @OA\Schema(
 *     schema="UpdateAppointmentRequest",
 *     type="object",
 *     @OA\Property(property="patient_id", type="integer", example=1),
 *     @OA\Property(property="doctor_id", type="integer", example=1),
 *     @OA\Property(property="appointment_date", type="string", format="date-time"),
 *     @OA\Property(property="status", type="string", example="completed"),
 *     @OA\Property(property="reason", type="string", nullable=true),
 *     @OA\Property(property="notes", type="string", nullable=true)
 * )
 *
 * @OA\Schema(
 *     schema="User",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="John Doe"),
 *     @OA\Property(property="email", type="string", format="email", example="john@example.com"),
 *     @OA\Property(property="email_verified_at", type="string", format="date-time", nullable=true, example="2023-01-01T12:00:00Z"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2023-01-01T12:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2023-01-01T12:00:00Z")
 * )
 *
 * @OA\Schema(
 *     schema="LoginRequest",
 *     type="object",
 *     required={"email", "password"},
 *     @OA\Property(property="email", type="string", format="email", example="user@example.com"),
 *     @OA\Property(property="password", type="string", format="password", example="password"),
 *     @OA\Property(property="remember", type="boolean", example=false)
 * )
 *
 * @OA\Schema(
 *     schema="LoginResponse",
 *     type="object",
 *     @OA\Property(property="token", type="string", example="1|abcdef123456"),
 *     @OA\Property(property="user", ref="#/components/schemas/User")
 * )
 *
 * @OA\Schema(
 *     schema="PaginationLinks",
 *     type="object",
 *     @OA\Property(property="first", type="string", example="http://example.com/api/resource?page=1"),
 *     @OA\Property(property="last", type="string", example="http://example.com/api/resource?page=5"),
 *     @OA\Property(property="prev", type="string", nullable=true, example="http://example.com/api/resource?page=1"),
 *     @OA\Property(property="next", type="string", nullable=true, example="http://example.com/api/resource?page=3")
 * )
 *
 * @OA\Schema(
 *     schema="PaginationMeta",
 *     type="object",
 *     @OA\Property(property="current_page", type="integer", example=2),
 *     @OA\Property(property="from", type="integer", example=11),
 *     @OA\Property(property="last_page", type="integer", example=5),
 *     @OA\Property(property="path", type="string", example="http://example.com/api/resource"),
 *     @OA\Property(property="per_page", type="integer", example=10),
 *     @OA\Property(property="to", type="integer", example=20),
 *     @OA\Property(property="total", type="integer", example=50)
 * )
 *
 * @OA\Schema(
 *     schema="MedicalRecord",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="patient_id", type="integer", example=1),
 *     @OA\Property(property="doctor_id", type="integer", example=1),
 *     @OA\Property(property="appointment_id", type="integer", nullable=true, example=1),
 *     @OA\Property(property="diagnosis", type="string", example="Diagnostic principal"),
 *     @OA\Property(property="treatment", type="string", example="Traitement prescrit"),
 *     @OA\Property(property="notes", type="string", nullable=true, example="Notes supplémentaires"),
 *     @OA\Property(property="follow_up_date", type="string", format="date", nullable=true, example="2023-12-31"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time"),
 *     @OA\Property(property="patient", ref="#/components/schemas/Patient"),
 *     @OA\Property(property="doctor", ref="#/components/schemas/User"),
 *     @OA\Property(property="appointment", ref="#/components/schemas/Appointment", nullable=true)
 * )
 *
 * @OA\Schema(
 *     schema="StoreMedicalRecordRequest",
 *     type="object",
 *     required={"patient_id", "diagnosis"},
 *     @OA\Property(property="patient_id", type="integer", example=1),
 *     @OA\Property(property="appointment_id", type="integer", nullable=true, example=1),
 *     @OA\Property(property="diagnosis", type="string", example="Diagnostic principal"),
 *     @OA\Property(property="treatment", type="string", example="Traitement prescrit"),
 *     @OA\Property(property="notes", type="string", nullable=true, example="Notes supplémentaires"),
 *     @OA\Property(property="follow_up_date", type="string", format="date", nullable=true, example="2023-12-31")
 * )
 *
 * @OA\Schema(
 *     schema="UpdateMedicalRecordRequest",
 *     type="object",
 *     @OA\Property(property="diagnosis", type="string", example="Diagnostic mis à jour"),
 *     @OA\Property(property="treatment", type="string", example="Nouveau traitement"),
 *     @OA\Property(property="notes", type="string", nullable=true, example="Notes mises à jour"),
 *     @OA\Property(property="follow_up_date", type="string", format="date", nullable=true, example="2024-01-31")
 * )
 *
 * @OA\Schema(
 *     schema="Patient",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="first_name", type="string", example="John"),
 *     @OA\Property(property="last_name", type="string", example="Doe"),
 *     @OA\Property(property="email", type="string", format="email", example="john.doe@example.com"),
 *     @OA\Property(property="phone", type="string", nullable=true, example="+1234567890"),
 *     @OA\Property(property="birth_date", type="string", format="date", example="1980-01-01"),
 *     @OA\Property(property="gender", type="string", enum={"male", "female", "other"}, example="male"),
 *     @OA\Property(property="address", type="string", nullable=true, example="123 Main St, City"),
 *     @OA\Property(property="city", type="string", nullable=true, example="Paris"),
 *     @OA\Property(property="postal_code", type="string", nullable=true, example="75000"),
 *     @OA\Property(property="country", type="string", nullable=true, example="France"),
 *     @OA\Property(property="blood_type", type="string", nullable=true, example="A+"),
 *     @OA\Property(property="allergies", type="string", nullable=true, example="Pollen, Penicillin"),
 *     @OA\Property(property="notes", type="string", nullable=true, example="Patient sous surveillance"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 *
 * Le schéma StorePatientRequest est défini dans le fichier StorePatientRequest.php
 *
 * Le schéma UpdatePatientRequest est défini dans le fichier UpdatePatientRequest.php
 *
 * @OA\Schema(
 *     schema="Organization",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Clinique du Nord"),
 *     @OA\Property(property="email", type="string", format="email", nullable=true, example="contact@clinique-nord.fr"),
 *     @OA\Property(property="phone", type="string", nullable=true, example="+33123456789"),
 *     @OA\Property(property="address", type="string", nullable=true, example="1 Rue de la Paix"),
 *     @OA\Property(property="city", type="string", nullable=true, example="Paris"),
 *     @OA\Property(property="postal_code", type="string", nullable=true, example="75001"),
 *     @OA\Property(property="country", type="string", nullable=true, example="France"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 *
 * @OA\Schema(
 *     schema="StoreOrganizationRequest",
 *     type="object",
 *     required={"name"},
 *     @OA\Property(property="name", type="string", example="Clinique du Nord"),
 *     @OA\Property(property="email", type="string", format="email", nullable=true, example="contact@clinique-nord.fr"),
 *     @OA\Property(property="phone", type="string", nullable=true, example="+33123456789"),
 *     @OA\Property(property="address", type="string", nullable=true, example="1 Rue de la Paix")
 * )
 *
 * @OA\Schema(
 *     schema="UpdateOrganizationRequest",
 *     type="object",
 *     @OA\Property(property="name", type="string", example="Clinique du Nord"),
 *     @OA\Property(property="email", type="string", format="email", nullable=true, example="contact@clinique-nord.fr"),
 *     @OA\Property(property="phone", type="string", nullable=true, example="+33123456789"),
 *     @OA\Property(property="address", type="string", nullable=true, example="1 Rue de la Paix")
 * )
 */
class Schemas
{
    // Classe vide, utilisée uniquement pour la documentation
}
