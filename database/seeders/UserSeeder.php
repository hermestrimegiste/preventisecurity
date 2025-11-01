<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $clinicAlpha = Organization::where('slug', 'clinic-alpha')->first();
        $clinicBeta = Organization::where('slug', 'clinic-beta')->first();
        $metroHospital = Organization::where('slug', 'metropolitan-hospital')->first();

        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@demo.com',
            'password' => Hash::make('password'),
            'current_organization_id' => $clinicAlpha->id,
        ]);
        $admin->assignRole('admin');
        $admin->organizations()->attach($clinicAlpha->id);

        $doctor = User::create([
            'name' => 'Dr. John Smith',
            'email' => 'doctor@demo.com',
            'password' => Hash::make('password'),
            'current_organization_id' => $clinicAlpha->id,
        ]);
        $doctor->assignRole('doctor');
        $doctor->organizations()->attach([$clinicAlpha->id, $clinicBeta->id]);

        $doctorBeta = User::create([
            'name' => 'Dr. Sarah Johnson',
            'email' => 'doctor.beta@demo.com',
            'password' => Hash::make('password'),
            'current_organization_id' => $clinicBeta->id,
        ]);
        $doctorBeta->assignRole('doctor');
        $doctorBeta->organizations()->attach($clinicBeta->id);

        $adminMetro = User::create([
            'name' => 'Metro Admin',
            'email' => 'admin.metro@demo.com',
            'password' => Hash::make('password'),
            'current_organization_id' => $metroHospital->id,
        ]);
        $adminMetro->assignRole('admin');
        $adminMetro->organizations()->attach($metroHospital->id);

        $doctorMetro = User::create([
            'name' => 'Dr. Michael Brown',
            'email' => 'doctor.metro@demo.com',
            'password' => Hash::make('password'),
            'current_organization_id' => $metroHospital->id,
        ]);
        $doctorMetro->assignRole('doctor');
        $doctorMetro->organizations()->attach($metroHospital->id);

        $this->command->info('Users created successfully!');
        $this->command->info('');
        $this->command->info('Demo Credentials:');
        $this->command->info('Admin (Clinic Alpha): admin@demo.com / password');
        $this->command->info('Doctor (Multi-Org): doctor@demo.com / password');
        $this->command->info('Doctor (Beta Only): doctor.beta@demo.com / password');
        $this->command->info('Admin (Metro): admin.metro@demo.com / password');
        $this->command->info('Doctor (Metro): doctor.metro@demo.com / password');
    }
}
