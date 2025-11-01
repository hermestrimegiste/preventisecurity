<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrganizationController extends Controller
{
    public function switch(Organization $organization)
    {
        if (!auth()->user()->belongsToOrganization($organization->id)) {
            abort(403, 'You do not have access to this organization.');
        }

        auth()->user()->switchOrganization($organization->id);

        return redirect()->back()->with('success', "Switched to {$organization->name}");
    }

    public function settings()
    {
        $organization = auth()->user()->currentOrganization;

        return Inertia::render('Organization/Settings', [
            'organization' => $organization,
        ]);
    }

    public function updateSettings(Request $request)
    {
        $organization = auth()->user()->currentOrganization;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        $organization->update($validated);

        return back()->with('success', 'Organization settings updated successfully.');
    }

    public function members()
    {
        $organization = auth()->user()->currentOrganization;
        $members = $organization->users()->with('roles')->get();

        return Inertia::render('Organization/Members', [
            'organization' => $organization,
            'members' => $members,
        ]);
    }

    public function invite(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|exists:users,email',
            'role' => 'required|in:admin,doctor',
        ]);

        $user = User::where('email', $validated['email'])->first();
        $organization = auth()->user()->currentOrganization;

        if ($user->belongsToOrganization($organization->id)) {
            return back()->with('error', 'User already belongs to this organization.');
        }

        $user->organizations()->attach($organization->id);
        $user->assignRole($validated['role']);

        return back()->with('success', 'User invited successfully.');
    }

    public function removeMember(User $user)
    {
        $organization = auth()->user()->currentOrganization;

        if (!$user->belongsToOrganization($organization->id)) {
            return back()->with('error', 'User does not belong to this organization.');
        }

        $user->organizations()->detach($organization->id);

        if ($user->current_organization_id === $organization->id) {
            $user->update(['current_organization_id' => null]);
        }

        return back()->with('success', 'User removed from organization.');
    }
}
