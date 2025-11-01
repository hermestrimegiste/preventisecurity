<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'manage organizations',
            'view organizations',
            'manage users',
            'view users',
            'invite users',
            'create patients',
            'view patients',
            'edit patients',
            'delete patients',
            'create appointments',
            'view appointments',
            'edit appointments',
            'delete appointments',
            'cancel appointments',
            'create medical records',
            'view medical records',
            'edit medical records',
            'delete medical records',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo([
            'manage organizations',
            'view organizations',
            'manage users',
            'view users',
            'invite users',
            'create patients',
            'view patients',
            'edit patients',
            'delete patients',
            'create appointments',
            'view appointments',
            'edit appointments',
            'delete appointments',
            'cancel appointments',
            'create medical records',
            'view medical records',
            'edit medical records',
            'delete medical records',
        ]);

        $doctorRole = Role::create(['name' => 'doctor']);
        $doctorRole->givePermissionTo([
            'create patients',
            'view patients',
            'edit patients',
            'create appointments',
            'view appointments',
            'edit appointments',
            'cancel appointments',
            'create medical records',
            'view medical records',
            'edit medical records',
        ]);

        $this->command->info('Roles and permissions created successfully!');
    }
}
