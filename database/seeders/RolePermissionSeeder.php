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
            // Organization Management
            'manage organizations',
            'view organizations',
            
            // User Management
            'manage users',
            'view users',
            'invite users',
            
            // Respondent Management
            'create respondents',
            'view respondents',
            'edit respondents',
            'delete respondents',
            'export respondents',
            
            // Assessment Management
            'create assessments',
            'view assessments',
            'edit assessments',
            'delete assessments',
            'submit assessments',
            
            // Report Management
            'view reports',
            'generate reports',
            'share reports',
            'export reports',
            
            // Booking Management
            'create bookings',
            'view bookings',
            'edit bookings',
            'cancel bookings',
            
            // CMS Management
            'manage cms',
            'view cms',
            'edit questions',
            'edit content',
            
            // Analytics
            'view analytics',
            'export data',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Admin Role - Full access
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        // Consultant Role - Assessment & client management
        $consultantRole = Role::create(['name' => 'consultant']);
        $consultantRole->givePermissionTo([
            'view organizations',
            'view users',
            'create respondents',
            'view respondents',
            'edit respondents',
            'create assessments',
            'view assessments',
            'edit assessments',
            'submit assessments',
            'view reports',
            'generate reports',
            'share reports',
            'create bookings',
            'view bookings',
            'edit bookings',
            'cancel bookings',
            'view cms',
            'view analytics',
        ]);

        // Analyst Role - Read-only analytics
        $analystRole = Role::create(['name' => 'analyst']);
        $analystRole->givePermissionTo([
            'view organizations',
            'view respondents',
            'view assessments',
            'view reports',
            'view analytics',
            'export data',
        ]);

        $this->command->info('Roles and permissions created successfully!');
        $this->command->info('Roles: admin, consultant, analyst');
    }
}
