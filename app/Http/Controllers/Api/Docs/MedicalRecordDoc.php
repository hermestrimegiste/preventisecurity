<?php

namespace App\Http\Controllers\Api\Docs;

use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Medical Records",
 *     description="Patient medical records management"
 * )
 */
class MedicalRecordDoc
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
    public function store() {}

    /**
     * @OA\Get(
     *     path="/api/medical-records/{medicalRecord}",
     *     summary="Get a specific medical record",
     *     tags={"Medical Records"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="medicalRecord",
     *         in="path",
     *         required=true,
     *         description="Medical record ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Medical record retrieved successfully",
     *         @OA\JsonContent(ref="#/components/schemas/MedicalRecord")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Medical record not found"
     *     )
     * )
     */
    public function show() {}

    /**
     * @OA\Put(
     *     path="/api/medical-records/{medicalRecord}",
     *     summary="Update a medical record",
     *     tags={"Medical Records"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="medicalRecord",
     *         in="path",
     *         required=true,
     *         description="Medical record ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateMedicalRecordRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Medical record updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/MedicalRecord")
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Unauthorized action"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Medical record not found"
     *     )
     * )
     */
    public function update() {}

    /**
     * @OA\Delete(
     *     path="/api/medical-records/{medicalRecord}",
     *     summary="Delete a medical record",
     *     tags={"Medical Records"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="medicalRecord",
     *         in="path",
     *         required=true,
     *         description="Medical record ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Medical record deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Unauthorized action"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Medical record not found"
     *     )
     * )
     */
    public function destroy() {}

    /**
     * @OA\Get(
     *     path="/api/patients/{patient}/medical-records",
     *     summary="List patient's medical records",
     *     tags={"Medical Records"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="patient",
     *         in="path",
     *         required=true,
     *         description="Patient ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of medical records",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/MedicalRecord")),
     *             @OA\Property(property="links", ref="#/components/schemas/PaginationLinks"),
     *             @OA\Property(property="meta", ref="#/components/schemas/PaginationMeta")
     *         )
     *     )
     * )
     */
    public function byPatient() {}

    /**
     * @OA\Get(
     *     path="/api/medical-records/follow-ups",
     *     summary="List upcoming and overdue follow-ups",
     *     tags={"Medical Records"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of follow-ups",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="upcoming",
     *                 type="object",
     *                 @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/MedicalRecord")),
     *                 @OA\Property(property="links", ref="#/components/schemas/PaginationLinks"),
     *                 @OA\Property(property="meta", ref="#/components/schemas/PaginationMeta")
     *             ),
     *             @OA\Property(
     *                 property="overdue",
     *                 type="object",
     *                 @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/MedicalRecord")),
     *                 @OA\Property(property="links", ref="#/components/schemas/PaginationLinks"),
     *                 @OA\Property(property="meta", ref="#/components/schemas/PaginationMeta")
     *             )
     *         )
     *     )
     * )
     */
    public function followUps() {}
}
