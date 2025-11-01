<?php

namespace App\Http\Controllers\Api;

use App\Models\Organization;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Organizations",
 *     description="Endpoints for managing organizations"
 * )
 */

class OrganizationController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/organizations",
     *     summary="List all organizations for the authenticated user",
     *     tags={"Organizations"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of organizations",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Organization")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     )
     * )
     */
    public function index()
    {
        $organizations = auth()->user()->organizations;

        return response()->json($organizations);
    }

    public function current()
    {
        $organization = auth()->user()->currentOrganization;

        return response()->json($organization);
    }

    public function show(Organization $organization)
    {
        if (!auth()->user()->belongsToOrganization($organization->id)) {
            abort(403, 'You do not have access to this organization.');
        }

        return response()->json($organization);
    }

    public function switch(Organization $organization)
    {
        if (!auth()->user()->belongsToOrganization($organization->id)) {
            abort(403, 'You do not have access to this organization.');
        }

        auth()->user()->switchOrganization($organization->id);

        return response()->json([
            'message' => "Switched to {$organization->name}",
            'organization' => $organization,
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('manage organizations');

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        $organization = Organization::create($validated);

        return response()->json($organization, 201);
    }

    public function update(Request $request, Organization $organization)
    {
        $this->authorize('manage organizations');

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        $organization->update($validated);

        return response()->json($organization);
    }

    public function destroy(Organization $organization)
    {
        $this->authorize('manage organizations');

        $organization->delete();

        return response()->json(null, 204);
    }
}

