<?php

namespace App\Http\Controllers\Api\Docs;

/**
 * @OA\Schema(
 *     schema="Organization",
 *     type="object",
 *     required={"name"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Acme Clinic"),
 *     @OA\Property(property="slug", type="string", example="acme-clinic"),
 *     @OA\Property(property="email", type="string", format="email", example="info@acmeclinic.com", nullable=true),
 *     @OA\Property(property="phone", type="string", example="+1234567890", nullable=true),
 *     @OA\Property(property="address", type="string", example="123 Medical Center Dr, City, Country", nullable=true),
 *     @OA\Property(property="is_active", type="boolean", example=true),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time"),
 *     @OA\Property(property="deleted_at", type="string", format="date-time", nullable=true)
 * )
 * 
 * @OA\Schema(
 *     schema="StoreOrganizationRequest",
 *     required={"name"},
 *     @OA\Property(property="name", type="string", example="Acme Clinic", maxLength=255),
 *     @OA\Property(property="email", type="string", format="email", example="info@acmeclinic.com", maxLength=255, nullable=true),
 *     @OA\Property(property="phone", type="string", example="+1234567890", maxLength=20, nullable=true),
 *     @OA\Property(property="address", type="string", example="123 Medical Center Dr, City, Country", maxLength=500, nullable=true)
 * )
 * 
 * @OA\Schema(
 *     schema="UpdateOrganizationRequest",
 *     @OA\Property(property="name", type="string", example="Acme Clinic", maxLength=255, nullable=true),
 *     @OA\Property(property="email", type="string", format="email", example="info@acmeclinic.com", maxLength=255, nullable=true),
 *     @OA\Property(property="phone", type="string", example="+1234567890", maxLength=20, nullable=true),
 *     @OA\Property(property="address", type="string", example="123 Medical Center Dr, City, Country", maxLength=500, nullable=true),
 *     @OA\Property(property="is_active", type="boolean", example=true, nullable=true)
 * )
 * 
 * @OA\Schema(
 *     schema="User",
 *     type="object",
 *     required={"name", "email"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="John Doe"),
 *     @OA\Property(property="email", type="string", format="email", example="john.doe@example.com"),
 *     @OA\Property(property="email_verified_at", type="string", format="date-time", nullable=true),
 *     @OA\Property(property="current_organization_id", type="integer", example=1, nullable=true),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class OrganizationDoc
{
    // This class is used only for Swagger documentation
}
