<?php

namespace Tests\Feature;

use App\Models\Organization;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class MultiTenantIsolationTest extends TestCase
{
    use RefreshDatabase;

    protected $orgA;
    protected $orgB;
    protected $userA;
    protected $userB;
    protected $patientA;
    protected $patientB;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Créer les rôles et permissions nécessaires
        $this->artisan('db:seed', ['--class' => 'RolePermissionSeeder']);
        
        $this->orgA = Organization::factory()->create(['name' => 'Clinic A']);
        $this->orgB = Organization::factory()->create(['name' => 'Clinic B']);

        $this->userA = User::factory()->create(['current_organization_id' => $this->orgA->id]);
        $this->userA->organizations()->attach($this->orgA->id);
        $this->userA->assignRole('doctor');

        $this->userB = User::factory()->create(['current_organization_id' => $this->orgB->id]);
        $this->userB->organizations()->attach($this->orgB->id);
        $this->userB->assignRole('doctor');

        $this->patientA = Patient::factory()->create([
            'organization_id' => $this->orgA->id,
            'first_name' => 'John',
            'last_name' => 'Doe',
        ]);

        $this->patientB = Patient::factory()->create([
            'organization_id' => $this->orgB->id,
            'first_name' => 'Jane',
            'last_name' => 'Smith',
        ]);
    }

    #[Test]
    public function user_can_only_see_patients_from_their_organization()
    {
        $this->actingAs($this->userA);

        $patients = Patient::all();

        $this->assertCount(1, $patients);
        $this->assertEquals($this->patientA->id, $patients->first()->id);
        $this->assertEquals('John', $patients->first()->first_name);
    }

    #[Test]
    public function user_cannot_access_patients_from_other_organizations()
    {
        $this->actingAs($this->userA);

        $patient = Patient::find($this->patientB->id);

        $this->assertNull($patient);
    }

    #[Test]
    public function user_can_access_patient_from_their_organization_via_route()
    {
        $this->actingAs($this->userA);

        $response = $this->get(route('patients.show', $this->patientA));

        $response->assertOk();
    }

    #[Test]
    public function user_cannot_access_patient_from_other_organization_via_route()
    {
        $this->actingAs($this->userA);

        $response = $this->get(route('patients.show', $this->patientB));

        $response->assertNotFound();
    }

    #[Test]
    public function patient_is_automatically_assigned_to_current_organization_on_creation()
    {
        $this->actingAs($this->userA);

        $newPatient = Patient::create([
            'first_name' => 'Test',
            'last_name' => 'Patient',
            'date_of_birth' => '1995-05-15',
            'gender' => 'male',
            'phone' => '+1234567890',
        ]);

        $this->assertEquals($this->orgA->id, $newPatient->organization_id);
    }

    #[Test]
    public function user_with_multiple_organizations_can_switch_context()
    {
        $multiOrgUser = User::factory()->create([
            'current_organization_id' => $this->orgA->id
        ]);
        $multiOrgUser->organizations()->attach([$this->orgA->id, $this->orgB->id]);
        $multiOrgUser->assignRole('doctor');

        $this->actingAs($multiOrgUser);

        $patients = Patient::all();
        $this->assertCount(1, $patients);
        $this->assertEquals($this->patientA->id, $patients->first()->id);

        $multiOrgUser->switchOrganization($this->orgB->id);
        $multiOrgUser->refresh();

        $patients = Patient::all();
        $this->assertCount(1, $patients);
        $this->assertEquals($this->patientB->id, $patients->first()->id);
    }

    #[Test]
    public function updating_patient_does_not_change_organization_id()
    {
        $this->actingAs($this->userA);

        $originalOrgId = $this->patientA->organization_id;

        $this->patientA->update([
            'first_name' => 'Updated',
        ]);

        $this->assertEquals($originalOrgId, $this->patientA->fresh()->organization_id);
    }

    #[Test]
    public function unauthorized_user_cannot_create_patient()
    {
        $unauthorizedUser = User::factory()->create([
            'current_organization_id' => $this->orgA->id
        ]);
        $unauthorizedUser->organizations()->attach($this->orgA->id);

        $this->actingAs($unauthorizedUser);

        $response = $this->post(route('patients.store'), [
            'first_name' => 'Test',
            'last_name' => 'Patient',
            'date_of_birth' => '1995-05-15',
            'gender' => 'male',
            'phone' => '+1234567890',
        ]);

        $response->assertForbidden();
    }
}
