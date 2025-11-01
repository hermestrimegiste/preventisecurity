<?php

namespace App\Http\Schemas;

/**
 * @OA\Schema(
 *     schema="Patient",
 *     required={"id", "name", "email"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         format="email"
 *     ),
 *     @OA\Property(
 *         property="phone",
 *         type="string",
 *         nullable=true
 *     ),
 *     @OA\Property(
 *         property="address",
 *         type="string",
 *         nullable=true
 *     ),
 *     @OA\Property(
 *         property="date_of_birth",
 *         type="string",
 *         format="date",
 *         nullable=true
 *     )
 * )
 */
class PatientSchema
{
    // This class is used for Swagger documentation only
}
