<?php

namespace App\Http\Controllers\Api;

use App\Models\Organization;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    /**
     * List all organizations for the authenticated user.
     */
    public function index()
    {
        $organizations = auth()->user()->organizations;

        return response()->json($organizations);
    }

    /**
     * Get the current organization of the authenticated user.
     */
    public function current()
    {
        $organization = auth()->user()->currentOrganization;

        return response()->json($organization);
    }

    /**
     * Display the specified organization.
     */
    public function show(Organization $organization)
    {
        if (!auth()->user()->belongsToOrganization($organization->id)) {
            abort(403, 'You do not have access to this organization.');
        }

        return response()->json($organization);
    }

    /**
     * Switch to a different organization.
     */
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

    /**
     * Store a newly created organization in storage.
     */
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

    /**
     * Update the specified organization in storage.
     */
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

    /**
     * Remove the specified organization from storage.
     */
    public function destroy(Organization $organization)
    {
        $this->authorize('manage organizations');

        $organization->delete();

        return response()->json(null, 204);
    }
}

