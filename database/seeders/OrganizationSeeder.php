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
                'name' => 'Clinic Alpha',
                'slug' => 'clinic-alpha',
                'email' => 'contact@clinic-alpha.com',
                'phone' => '+1234567890',
                'address' => '123 Medical Street, Health City, HC 12345',
                'is_active' => true,
            ],
            [
                'name' => 'Clinic Beta',
                'slug' => 'clinic-beta',
                'email' => 'info@clinic-beta.com',
                'phone' => '+0987654321',
                'address' => '456 Healthcare Avenue, Wellness Town, WT 67890',
                'is_active' => true,
            ],
            [
                'name' => 'Metropolitan Hospital',
                'slug' => 'metropolitan-hospital',
                'email' => 'admin@metro-hospital.com',
                'phone' => '+1122334455',
                'address' => '789 Hospital Road, Metro City, MC 11223',
                'is_active' => true,
            ],
        ];

        foreach ($organizations as $org) {
            Organization::create($org);
        }

        $this->command->info('Organizations created successfully!');
    }
}
