<?php

namespace App\Http\Controllers\Api\Docs;

use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Organizations",
 *     description="Organization and context switching management"
 * )
 */
class OrganizationDoc
{
    /**
     * @OA\Get(
     *     path="/api/organizations",
     *     summary="List user's organizations",
     *     tags={"Organizations"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of organizations",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Organization")
     *         )
     *     )
     * )
     */
    public function index() {}

    /**
     * @OA\Get(
     *     path="/api/organizations/current",
     *     summary="Get current organization",
     *     tags={"Organizations"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Current organization",
     *         @OA\JsonContent(ref="#/components/schemas/Organization")
     *     )
     * )
     */
    public function current() {}

    /**
     * @OA\Get(
     *     path="/api/organizations/{organization}",
     *     summary="Show a specific organization",
     *     tags={"Organizations"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="organization",
     *         in="path",
     *         required=true,
     *         description="Organization ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Organization details",
     *         @OA\JsonContent(ref="#/components/schemas/Organization")
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Access denied to this organization"
     *     )
     * )
     */
    public function show() {}

    /**
     * @OA\Post(
     *     path="/api/organizations/switch/{organization}",
     *     summary="Switch current organization",
     *     tags={"Organizations"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="organization",
     *         in="path",
     *         required=true,
     *         description="ID of the organization to switch to",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Organization switched successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="organization", ref="#/components/schemas/Organization")
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Access denied to this organization"
     *     )
     * )
     */
    public function switch() {}

    /**
     * @OA\Post(
     *     path="/api/organizations",
     *     summary="Create a new organization",
     *     tags={"Organizations"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreOrganizationRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Organization created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Organization")
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Insufficient permissions to create an organization"
     *     )
     * )
     */
    public function store() {}

    /**
     * @OA\Put(
     *     path="/api/organizations/{organization}",
     *     summary="Update an organization",
     *     tags={"Organizations"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="organization",
     *         in="path",
     *         required=true,
     *         description="Organization ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateOrganizationRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Organization updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Organization")
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Insufficient permissions to update this organization"
     *     )
     * )
     */
    public function update() {}

    /**
     * @OA\Delete(
     *     path="/api/organizations/{organization}",
     *     summary="Delete an organization",
     *     tags={"Organizations"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="organization",
     *         in="path",
     *         required=true,
     *         description="ID of the organization to delete",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Organization deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Insufficient permissions to delete this organization"
     *     )
     * )
     */
    public function destroy() {}
}
