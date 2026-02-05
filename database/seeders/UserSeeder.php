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
        $secureTech = Organization::where('slug', 'securetech')->first();
        $cyberShield = Organization::where('slug', 'cybershield')->first();
        $dataGuard = Organization::where('slug', 'dataguard')->first();

        // Admin for SecureTech
        $admin = User::create([
            'name' => 'Marc Dubois',
            'email' => 'admin@demo.com',
            'password' => Hash::make('password'),
            'current_organization_id' => $secureTech->id,
        ]);
        $admin->assignRole('admin');
        $admin->organizations()->attach($secureTech->id);

        // Consultant with multi-org access
        $consultant = User::create([
            'name' => 'Sophie Bernard',
            'email' => 'consultant@demo.com',
            'password' => Hash::make('password'),
            'current_organization_id' => $secureTech->id,
        ]);
        $consultant->assignRole('consultant');
        $consultant->organizations()->attach([$secureTech->id, $cyberShield->id]);

        // Consultant for CyberShield only
        $consultantCs = User::create([
            'name' => 'Thomas Laurent',
            'email' => 'consultant.cs@demo.com',
            'password' => Hash::make('password'),
            'current_organization_id' => $cyberShield->id,
        ]);
        $consultantCs->assignRole('consultant');
        $consultantCs->organizations()->attach($cyberShield->id);

        // Admin for DataGuard
        $adminDg = User::create([
            'name' => 'Claire Martin',
            'email' => 'admin.dg@demo.com',
            'password' => Hash::make('password'),
            'current_organization_id' => $dataGuard->id,
        ]);
        $adminDg->assignRole('admin');
        $adminDg->organizations()->attach($dataGuard->id);

        // Analyst for DataGuard
        $analystDg = User::create([
            'name' => 'Pierre Leroy',
            'email' => 'analyst.dg@demo.com',
            'password' => Hash::make('password'),
            'current_organization_id' => $dataGuard->id,
        ]);
        $analystDg->assignRole('analyst');
        $analystDg->organizations()->attach($dataGuard->id);

        $this->command->info('Users created successfully!');
        $this->command->info('');
        $this->command->info('Demo Credentials:');
        $this->command->info('Admin (SecureTech): admin@demo.com / password');
        $this->command->info('Consultant (Multi-Org): consultant@demo.com / password');
        $this->command->info('Consultant (CyberShield): consultant.cs@demo.com / password');
        $this->command->info('Admin (DataGuard): admin.dg@demo.com / password');
        $this->command->info('Analyst (DataGuard): analyst.dg@demo.com / password');
    }
}
