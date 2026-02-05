<?php

namespace Database\Seeders;

use App\Models\Organization;
use Illuminate\Database\Seeder;

class OrganizationSeeder extends Seeder
{
    public function run(): void
    {
        $organizations = [
            [
                'name' => 'SecureTech Consulting',
                'slug' => 'securetech',
                'email' => 'contact@securetech-consulting.com',
                'phone' => '+33 1 23 45 67 89',
                'address' => '12 Avenue de la Cybersécurité, 75008 Paris, France',
                'is_active' => true,
            ],
            [
                'name' => 'CyberShield Partners',
                'slug' => 'cybershield',
                'email' => 'info@cybershield.eu',
                'phone' => '+33 4 56 78 90 12',
                'address' => '34 Rue de la Défense, 69003 Lyon, France',
                'is_active' => true,
            ],
            [
                'name' => 'DataGuard Solutions',
                'slug' => 'dataguard',
                'email' => 'admin@dataguard-solutions.fr',
                'phone' => '+33 5 67 89 01 23',
                'address' => '56 Boulevard Innovation, 31000 Toulouse, France',
                'is_active' => true,
            ],
        ];

        foreach ($organizations as $org) {
            Organization::create($org);
        }

        $this->command->info('Organizations created successfully!');
        $this->command->info('Consultancy firms: SecureTech, CyberShield, DataGuard');
    }
}
