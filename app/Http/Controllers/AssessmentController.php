<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\Respondent;
use App\Models\CmsQuestion;
use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class AssessmentController extends Controller
{
    /**
     * Show the assessment start page
     */
    public function start(Request $request)
    {
        $level = $request->query('level', 'express');
        
        return Inertia::render('Assessment/Start', [
            'level' => $level,
        ]);
    }

    /**
     * Create respondent and assessment
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'company_name' => 'nullable|string|max:255',
            'role' => 'nullable|string|max:100',
            'locale' => 'required|in:fr,en',
            'assessment_level' => 'required|in:express,detailed',
            'consent_gdpr' => 'required|accepted',
        ]);

        // Check if respondent already exists
        $respondent = Respondent::where('email', $validated['email'])->first();

        if (!$respondent) {
            // Create new respondent
            $respondent = Respondent::create([
                'organization_id' => 1, // Default to first organization (demo)
                'email' => $validated['email'],
                'company_name' => $validated['company_name'],
                'role' => $validated['role'],
                'locale' => $validated['locale'],
                'consent_gdpr_at' => now(),
            ]);
        } else {
            // Update consent timestamp
            $respondent->update(['consent_gdpr_at' => now()]);
        }

        // Generate magic link
        $respondent->generateMagicLink();

        // Create new assessment
        $assessment = Assessment::create([
            'organization_id' => $respondent->organization_id,
            'respondent_id' => $respondent->id,
            'assessment_level' => $validated['assessment_level'],
            'status' => 'draft',
            'version' => 1,
        ]);

        $assessment->markAsStarted();

        // Redirect to assessment form with magic link token
        return redirect()->route('assessment.form', [
            'token' => $respondent->magic_link_token,
            'level' => $validated['assessment_level'],
        ]);
    }

    /**
     * Show assessment form (Express or Detailed)
     */
    public function form(Request $request, string $token)
    {
        $level = $request->query('level', 'express');

        // Validate magic link
        $respondent = Respondent::where('magic_link_token', $token)->firstOrFail();

        if (!$respondent->isMagicLinkValid()) {
            return redirect()->route('home')->with('error', 'Lien expiré. Veuillez recommencer.');
        }

        // Get or create in-progress assessment
        $assessment = $respondent->assessments()
            ->where('assessment_level', $level)
            ->whereIn('status', ['draft', 'in_progress'])
            ->latest()
            ->first();

        if (!$assessment) {
            return redirect()->route('assessment.start', ['level' => $level])
                ->with('error', 'Assessment introuvable.');
        }

        // Load questions for this level
        $questions = CmsQuestion::with('section')
            ->active()
            ->forLevel($level)
            ->ordered()
            ->get();

        // Load existing answers
        $existingAnswers = $assessment->answers()
            ->with('question')
            ->get()
            ->groupBy('question_id');

        return Inertia::render('Assessment/Form', [
            'assessment' => $assessment->load('respondent'),
            'questions' => $questions,
            'existingAnswers' => $existingAnswers,
            'level' => $level,
            'progress' => $assessment->completionPercentage(),
        ]);
    }

    /**
     * Save answer (auto-save endpoint)
     */
    public function saveAnswer(Request $request, Assessment $assessment)
    {
        $validated = $request->validate([
            'question_id' => 'required|exists:cms_questions,id',
            'value' => 'nullable|string',
            'custom_value' => 'nullable|array',
            'is_custom' => 'boolean',
        ]);

        // Update or create answer
        $answer = Answer::updateOrCreate(
            [
                'assessment_id' => $assessment->id,
                'question_id' => $validated['question_id'],
            ],
            [
                'value' => $validated['value'] ?? null,
                'custom_value' => $validated['custom_value'] ?? null,
                'is_custom' => $validated['is_custom'] ?? false,
            ]
        );

        return response()->json([
            'success' => true,
            'answer' => $answer,
            'progress' => $assessment->completionPercentage(),
        ]);
    }

    /**
     * Submit assessment
     */
    public function submit(Assessment $assessment)
    {
        $assessment->markAsSubmitted();

        // Generate report immediately (for MVP; use queue in production)
        $reportController = new \App\Http\Controllers\ReportController();
        $reportController->generate($assessment);

        return redirect()->route('assessment.complete', [
            'assessment' => $assessment->id,
        ]);
    }

    /**
     * Assessment completion page
     */
    public function complete(Assessment $assessment)
    {
        return Inertia::render('Assessment/Complete', [
            'assessment' => $assessment->load(['respondent', 'scores', 'recommendations']),
            'message' => 'Votre diagnostic a été soumis avec succès !',
        ]);
    }

    /**
     * Resume assessment via magic link
     */
    public function resume(string $token)
    {
        $respondent = Respondent::where('magic_link_token', $token)->firstOrFail();

        if (!$respondent->isMagicLinkValid()) {
            return redirect()->route('home')->with('error', 'Lien expiré.');
        }

        // Get latest in-progress assessment
        $assessment = $respondent->assessments()
            ->whereIn('status', ['draft', 'in_progress'])
            ->latest()
            ->first();

        if (!$assessment) {
            return redirect()->route('assessment.start')
                ->with('info', 'Aucun diagnostic en cours. Commencez-en un nouveau.');
        }

        return redirect()->route('assessment.form', [
            'token' => $token,
            'level' => $assessment->assessment_level,
        ]);
    }
}
