<?php

namespace Database\Seeders;

use App\Models\CmsSection;
use App\Models\CmsQuestion;
use Illuminate\Database\Seeder;

class CmsQuestionSeeder extends Seeder
{
    public function run(): void
    {
        $businessContextSection = CmsSection::where('slug', 'business-context')->first();

        // EXPRESS QUESTIONS (6 questions stratégiques)
        $expressQuestions = [
            [
                'section_id' => $businessContextSection->id,
                'question_text' => 'Quel est l\'objectif métier principal de votre solution ?',
                'help_text' => 'Comprendre votre secteur d\'activité nous permet d\'identifier les risques spécifiques et les réglementations applicables.',
                'help_link' => null,
                'assessment_level' => 'express',
                'answer_type' => 'single_choice',
                'options' => [
                    ['value' => 'finance', 'label' => 'Finance (paiements, crédit, banque)'],
                    ['value' => 'health', 'label' => 'Santé (télémédecine, dossiers patients)'],
                    ['value' => 'services', 'label' => 'Services B2B/B2C (SaaS, consulting)'],
                    ['value' => 'industry', 'label' => 'Industrie (production, logistique)'],
                    ['value' => 'other', 'label' => 'Autre secteur'],
                ],
                'dependencies' => null,
                'weight' => 2.0,
                'order' => 1,
                'is_active' => true,
            ],
            [
                'section_id' => $businessContextSection->id,
                'question_text' => 'Quels types de données sont traités par votre solution ?',
                'help_text' => 'Le type de données détermine le niveau de protection requis et les obligations de conformité (RGPD, PCI-DSS, etc.).',
                'help_link' => null,
                'assessment_level' => 'express',
                'answer_type' => 'multiple_choice',
                'options' => [
                    ['value' => 'none', 'label' => 'Aucune donnée sensible'],
                    ['value' => 'personal', 'label' => 'Données personnelles (nom, email, adresse)'],
                    ['value' => 'financial', 'label' => 'Données financières (IBAN, transactions)'],
                    ['value' => 'health', 'label' => 'Données de santé (dossiers médicaux)'],
                    ['value' => 'ip', 'label' => 'Propriété intellectuelle (brevets, plans)'],
                ],
                'dependencies' => null,
                'weight' => 2.5,
                'order' => 2,
                'is_active' => true,
            ],
            [
                'section_id' => $businessContextSection->id,
                'question_text' => 'Où est hébergée votre solution ?',
                'help_text' => 'L\'hébergement impacte votre responsabilité en matière de sécurité et les certifications requises.',
                'help_link' => null,
                'assessment_level' => 'express',
                'answer_type' => 'single_choice',
                'options' => [
                    ['value' => 'on-prem', 'label' => 'Infrastructure interne (on-premise)'],
                    ['value' => 'cloud-public', 'label' => 'Cloud public (AWS, Azure, GCP)'],
                    ['value' => 'cloud-private', 'label' => 'Cloud privé'],
                    ['value' => 'hybrid', 'label' => 'Infrastructure hybride'],
                ],
                'dependencies' => null,
                'weight' => 1.5,
                'order' => 3,
                'is_active' => true,
            ],
            [
                'section_id' => $businessContextSection->id,
                'question_text' => 'Quels partenaires ou fournisseurs tiers ont accès à vos données ?',
                'help_text' => 'Les intégrations tierces (paiement, email, SSO) peuvent introduire des risques de sécurité supplémentaires.',
                'help_link' => null,
                'assessment_level' => 'express',
                'answer_type' => 'text',
                'options' => null,
                'dependencies' => null,
                'weight' => 1.5,
                'order' => 4,
                'is_active' => true,
            ],
            [
                'section_id' => $businessContextSection->id,
                'question_text' => 'À quelles obligations réglementaires êtes-vous soumis ?',
                'help_text' => 'Les obligations légales déterminent les audits et certifications nécessaires.',
                'help_link' => null,
                'assessment_level' => 'express',
                'answer_type' => 'multiple_choice',
                'options' => [
                    ['value' => 'none', 'label' => 'Aucune contrainte réglementaire particulière'],
                    ['value' => 'gdpr', 'label' => 'RGPD (protection des données personnelles UE)'],
                    ['value' => 'pci-dss', 'label' => 'PCI-DSS (paiements par carte bancaire)'],
                    ['value' => 'hipaa', 'label' => 'HIPAA (santé États-Unis)'],
                    ['value' => 'hds', 'label' => 'HDS (hébergement données de santé France)'],
                    ['value' => 'iso27001', 'label' => 'ISO 27001 (certification sécurité)'],
                ],
                'dependencies' => null,
                'weight' => 2.0,
                'order' => 5,
                'is_active' => true,
            ],
            [
                'section_id' => $businessContextSection->id,
                'question_text' => 'Quels sont les impacts les plus critiques en cas d\'incident de sécurité ?',
                'help_text' => 'Identifier vos priorités nous permet de recommander les mesures de protection les plus adaptées.',
                'help_link' => null,
                'assessment_level' => 'express',
                'answer_type' => 'multiple_choice',
                'options' => [
                    ['value' => 'financial', 'label' => 'Perte financière directe'],
                    ['value' => 'reputation', 'label' => 'Atteinte à la réputation'],
                    ['value' => 'penalties', 'label' => 'Sanctions réglementaires (amendes CNIL, etc.)'],
                    ['value' => 'interruption', 'label' => 'Interruption de service'],
                    ['value' => 'ip-loss', 'label' => 'Vol de propriété intellectuelle'],
                ],
                'dependencies' => null,
                'weight' => 1.5,
                'order' => 6,
                'is_active' => true,
            ],
        ];

        foreach ($expressQuestions as $question) {
            CmsQuestion::create($question);
        }

        $this->command->info('CMS Questions created successfully!');
        $this->command->info('Express: 6 questions created');
    }
}
