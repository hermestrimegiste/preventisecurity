<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Assessment;

class DashboardController extends Controller
{
    /**
     * Display the dashboard
     */
    public function index()
    {
        $user = auth()->user();
        
        // Get assessments for the current organization
        $assessments = Assessment::where('organization_id', $user->current_organization_id)
            ->with(['respondent', 'report'])
            ->latest()
            ->take(10)
            ->get();

        return Inertia::render('Dashboard', [
            'assessments' => $assessments,
            'stats' => [
                'total_assessments' => Assessment::where('organization_id', $user->current_organization_id)->count(),
                'completed_assessments' => Assessment::where('organization_id', $user->current_organization_id)
                    ->where('status', 'completed')->count(),
                'in_progress' => Assessment::where('organization_id', $user->current_organization_id)
                    ->whereIn('status', ['draft', 'in_progress'])->count(),
            ],
        ]);
    }
}
