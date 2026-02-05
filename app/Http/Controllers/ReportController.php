<?php

namespace App\Http\Controllers;

use App\Models\Assessment;
use App\Models\Report;
use App\Models\Score;
use App\Models\Recommendation;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Str;

class ReportController extends Controller
{
    /**
     * View authenticated report
     */
    public function show(Assessment $assessment)
    {
        // TODO: Add policy authorization

        // Generate report if not exists
        if (!$assessment->report) {
            $this->generateReport($assessment);
        }

        $report = $assessment->report()->with('assessment.respondent')->first();
        $scores = $assessment->scores;
        $recommendations = $assessment->recommendations()->ordered()->get();

        return Inertia::render('Reports/Show', [
            'assessment' => $assessment->load('respondent'),
            'report' => $report,
            'scores' => $scores,
            'recommendations' => $recommendations,
        ]);
    }

    /**
     * Generate AI report (mock for MVP)
     */
    public function generate(Assessment $assessment)
    {
        // TODO: Add policy authorization

        $report = $this->generateReport($assessment);

        return redirect()->route('reports.show', $assessment)
            ->with('success', 'Rapport généré avec succès !');
    }

    /**
     * Generate share link
     */
    public function share(Assessment $assessment)
    {
        // TODO: Add policy authorization

        $report = $assessment->report;

        if (!$report) {
            return back()->with('error', 'Aucun rapport disponible.');
        }

        $shareUrl = $report->generateShareToken();

        return response()->json([
            'success' => true,
            'share_url' => $shareUrl,
            'expires_at' => $report->expires_at,
        ]);
    }

    /**
     * View shared report (public, no auth)
     */
    public function shared(string $token)
    {
        $report = Report::where('share_token', $token)->firstOrFail();

        if (!$report->isShareTokenValid()) {
            return redirect()->route('home')
                ->with('error', 'Ce lien de partage a expiré.');
        }

        $assessment = $report->assessment()->with('respondent')->first();
        $scores = $assessment->scores;
        $recommendations = $assessment->recommendations()->ordered()->get();

        return Inertia::render('Reports/Shared', [
            'assessment' => $assessment,
            'report' => $report,
            'scores' => $scores,
            'recommendations' => $recommendations,
            'isPublic' => true,
        ]);
    }

    /**
     * Download PDF
     */
    public function pdf(Assessment $assessment)
    {
        // TODO: Add policy authorization

        // TODO: Implement PDF generation with DomPDF or similar
        return back()->with('info', 'Génération PDF en cours de développement.');
    }

    /**
     * Mock AI Report Generation
     * TODO: Replace with real OpenAI GPT-4 integration
     */
    private function generateReport(Assessment $assessment): Report
    {
        // Calculate scores
        $this->calculateScores($assessment);

        // Generate recommendations
        $this->generateRecommendations($assessment);

        // Create report
        $report = Report::updateOrCreate(
            ['assessment_id' => $assessment->id],
            [
                'json_blob' => $this->generateReportBlob($assessment),
                'ai_prompt_version' => 'mock-v1',
                'generated_at' => now(),
            ]
        );

        $assessment->markAsCompleted();

        return $report;
    }

    /**
     * Calculate risk scores per domain (mock for MVP)
     */
    private function calculateScores(Assessment $assessment): void
    {
        $answers = $assessment->answers()->with('question')->get();

        // Define security domains
        $domains = [
            'Gouvernance' => 0,
            'Infrastructure' => 0,
            'Données' => 0,
            'Conformité' => 0,
            'Résilience' => 0,
        ];

        // Mock scoring logic based on answers
        foreach ($answers as $answer) {
            $weight = $answer->question->weight ?? 1.0;
            
            // Simple scoring: good answers = higher scores
            if (str_contains($answer->value, 'cloud')) {
                $domains['Infrastructure'] += 15 * $weight;
            }
            if (str_contains($answer->value, 'personal,financial')) {
                $domains['Données'] += 12 * $weight;
            }
            if (str_contains($answer->value, 'gdpr')) {
                $domains['Conformité'] += 18 * $weight;
            }
            if (str_contains($answer->value, 'health')) {
                $domains['Gouvernance'] += 10 * $weight;
                $domains['Conformité'] += 15 * $weight;
            }
        }

        // Normalize to 0-100 and save
        foreach ($domains as $domain => $rawScore) {
            $normalizedScore = min(100, max(0, $rawScore));
            $maturityLevel = $this->scoreToMaturity($normalizedScore);

            Score::updateOrCreate(
                [
                    'assessment_id' => $assessment->id,
                    'domain' => $domain,
                ],
                [
                    'score' => $normalizedScore,
                    'maturity_level' => $maturityLevel,
                ]
            );
        }
    }

    /**
     * Convert score to maturity level (0-5)
     */
    private function scoreToMaturity(float $score): int
    {
        return match(true) {
            $score >= 90 => 5, // Optimisé
            $score >= 70 => 4, // Avancé
            $score >= 50 => 3, // Intermédiaire
            $score >= 30 => 2, // Initial
            $score >= 10 => 1, // Ad-hoc
            default => 0,      // Inexistant
        };
    }

    /**
     * Generate mock recommendations
     */
    private function generateRecommendations(Assessment $assessment): void
    {
        $recommendations = [
            [
                'title' => 'Mettre en place une authentification à deux facteurs (2FA)',
                'description' => 'L\'absence de 2FA expose vos comptes administrateurs à des risques de compromission. Implémentez une solution 2FA (TOTP, SMS, ou hardware token) pour tous les comptes privilégiés.',
                'impact' => 'high',
                'effort' => 'small',
                'horizon' => '0-30j',
                'cost_range' => '€',
                'order' => 1,
            ],
            [
                'title' => 'Effectuer un audit de conformité RGPD',
                'description' => 'Votre activité traite des données personnelles dans l\'UE. Un audit RGPD permettra d\'identifier les écarts et de mettre en conformité votre registre de traitement.',
                'impact' => 'high',
                'effort' => 'medium',
                'horizon' => '30-90j',
                'cost_range' => '€€',
                'order' => 2,
            ],
            [
                'title' => 'Implémenter le chiffrement des données au repos',
                'description' => 'Les données sensibles doivent être chiffrées en base de données (AES-256). Utilisez des solutions de chiffrement transparent (TDE) ou des bibliothèques applicatives.',
                'impact' => 'high',
                'effort' => 'medium',
                'horizon' => '30-90j',
                'cost_range' => '€€',
                'order' => 3,
            ],
            [
                'title' => 'Mettre en place une politique de sauvegarde 3-2-1',
                'description' => 'Adoptez la règle 3-2-1 : 3 copies, 2 supports différents, 1 copie hors-site. Testez régulièrement la restauration pour garantir la résilience.',
                'impact' => 'medium',
                'effort' => 'small',
                'horizon' => '0-30j',
                'cost_range' => '€',
                'order' => 4,
            ],
            [
                'title' => 'Réaliser un pentest applicatif',
                'description' => 'Un test d\'intrusion permettra d\'identifier les vulnérabilités techniques de votre application (OWASP Top 10, injection, XSS, etc.).',
                'impact' => 'high',
                'effort' => 'large',
                'horizon' => '3-6mois',
                'cost_range' => '€€€',
                'order' => 5,
            ],
        ];

        foreach ($recommendations as $rec) {
            Recommendation::updateOrCreate(
                [
                    'assessment_id' => $assessment->id,
                    'title' => $rec['title'],
                ],
                $rec
            );
        }
    }

    /**
     * Generate report JSON blob
     */
    private function generateReportBlob(Assessment $assessment): array
    {
        $scores = $assessment->scores;
        $avgScore = $scores->avg('score') ?? 0;

        return [
            'executive_summary' => $this->generateExecutiveSummary($assessment, $avgScore),
            'risk_level' => $this->getRiskLevel($avgScore),
            'maturity_overall' => $this->scoreToMaturity($avgScore),
            'key_findings' => [
                'Votre infrastructure est partiellement sécurisée mais des améliorations sont nécessaires.',
                'La conformité RGPD nécessite des actions correctives.',
                'L\'authentification multi-facteurs est absente sur les comptes critiques.',
            ],
            'next_steps' => [
                'Implémenter les "Quick Wins" (actions 0-30 jours)',
                'Planifier un audit de sécurité complet',
                'Prendre rendez-vous avec un consultant pour prioriser les actions',
            ],
        ];
    }

    /**
     * Generate executive summary (mock)
     */
    private function generateExecutiveSummary(Assessment $assessment, float $avgScore): string
    {
        $company = $assessment->respondent->company_name ?? 'votre organisation';

        $maturityLevel = $this->scoreToMaturity($avgScore);
        $maturityLabels = ['Inexistant', 'Ad-hoc', 'Initial', 'Intermédiaire', 'Avancé', 'Optimisé'];
        $maturityLabel = $maturityLabels[$maturityLevel] ?? 'Initial';
        
        return "Votre diagnostic cybersécurité révèle un niveau de maturité " . 
               $maturityLabel . 
               " avec un score global de " . round($avgScore) . "/100. " .
               "Pour {$company}, les priorités sont : renforcer l'authentification, " .
               "mettre en conformité RGPD, et chiffrer les données sensibles. " .
               "Ces actions permettront de réduire significativement votre surface d'attaque.";
    }

    /**
     * Get risk level from score
     */
    private function getRiskLevel(float $score): string
    {
        return match(true) {
            $score >= 70 => 'Bon',
            $score >= 50 => 'Moyen',
            $score >= 30 => 'Élevé',
            default => 'Critique',
        };
    }
}
