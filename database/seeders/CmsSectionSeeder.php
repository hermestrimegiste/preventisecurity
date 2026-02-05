<?php

namespace Database\Seeders;

use App\Models\CmsSection;
use Illuminate\Database\Seeder;

class CmsSectionSeeder extends Seeder
{
    public function run(): void
    {
        $sections = [
            // Express sections (simplified for 6 questions)
            [
                'name' => 'Contexte Métier',
                'slug' => 'business-context',
                'description' => 'Questions stratégiques sur votre activité et vos données',
                'icon' => '🎯',
                'order' => 1,
                'assessment_level' => 'express',
            ],
            
            // Detailed sections (8 sections for technical assessment)
            [
                'name' => 'Secteur d\'Activité & Solution',
                'slug' => 'sector-solution',
                'description' => 'Type d\'activité et nature de la solution technique',
                'icon' => '🏢',
                'order' => 1,
                'assessment_level' => 'detailed',
            ],
            [
                'name' => 'Intégrations d\'API Tiers',
                'slug' => 'api-integrations',
                'description' => 'Services externes connectés à votre système',
                'icon' => '🔌',
                'order' => 2,
                'assessment_level' => 'detailed',
            ],
            [
                'name' => 'Nombre d\'Utilisateurs',
                'slug' => 'user-scale',
                'description' => 'Volume d\'utilisateurs et scale de votre solution',
                'icon' => '👥',
                'order' => 3,
                'assessment_level' => 'detailed',
            ],
            [
                'name' => 'Comptes Administrateurs',
                'slug' => 'admin-accounts',
                'description' => 'Gestion des accès privilégiés et authentification',
                'icon' => '🔐',
                'order' => 4,
                'assessment_level' => 'detailed',
            ],
            [
                'name' => 'Type de Données',
                'slug' => 'data-types',
                'description' => 'Nature et sensibilité des données traitées',
                'icon' => '📊',
                'order' => 5,
                'assessment_level' => 'detailed',
            ],
            [
                'name' => 'Stockage des Données',
                'slug' => 'data-storage',
                'description' => 'Protection et chiffrement des données',
                'icon' => '💾',
                'order' => 6,
                'assessment_level' => 'detailed',
            ],
            [
                'name' => 'Hébergement',
                'slug' => 'hosting',
                'description' => 'Infrastructure et environnement d\'hébergement',
                'icon' => '☁️',
                'order' => 7,
                'assessment_level' => 'detailed',
            ],
            [
                'name' => 'Obligations Réglementaires',
                'slug' => 'compliance',
                'description' => 'Conformité et contraintes légales',
                'icon' => '⚖️',
                'order' => 8,
                'assessment_level' => 'detailed',
            ],
        ];

        foreach ($sections as $section) {
            CmsSection::create($section);
        }

        $this->command->info('CMS Sections created successfully!');
        $this->command->info('Express: 1 section | Detailed: 8 sections');
    }
}
