<?php

use App\Models\Organization;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
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
});

test('user can only see patients from their organization', function () {
    $this->actingAs($this->userA);

    $patients = Patient::all();

    expect($patients)->toHaveCount(1)
        ->and($patients->first()->id)->toBe($this->patientA->id)
        ->and($patients->first()->first_name)->toBe('John');
});

test('user cannot access patients from other organizations', function () {
    $this->actingAs($this->userA);

    $patient = Patient::find($this->patientB->id);

    expect($patient)->toBeNull();
});

test('user can access patient from their organization via route', function () {
    $this->actingAs($this->userA);

    $response = $this->get(route('patients.show', $this->patientA));

    $response->assertOk();
});

test('user cannot access patient from other organization via route', function () {
    $this->actingAs($this->userA);

    $response = $this->get(route('patients.show', $this->patientB));

    $response->assertNotFound();
});

test('patient is automatically assigned to current organization on creation', function () {
    $this->actingAs($this->userA);

    $newPatient = Patient::create([
        'first_name' => 'Test',
        'last_name' => 'Patient',
        'date_of_birth' => '1995-05-15',
        'gender' => 'male',
        'phone' => '+1234567890',
    ]);

    expect($newPatient->organization_id)->toBe($this->orgA->id);
});

test('user with multiple organizations can switch context', function () {
    $multiOrgUser = User::factory()->create([
        'current_organization_id' => $this->orgA->id
    ]);
    $multiOrgUser->organizations()->attach([$this->orgA->id, $this->orgB->id]);
    $multiOrgUser->assignRole('doctor');

    $this->actingAs($multiOrgUser);

    $patients = Patient::all();
    expect($patients)->toHaveCount(1)
        ->and($patients->first()->id)->toBe($this->patientA->id);

    $multiOrgUser->switchOrganization($this->orgB->id);
    $multiOrgUser->refresh();

    $patients = Patient::all();
    expect($patients)->toHaveCount(1)
        ->and($patients->first()->id)->toBe($this->patientB->id);
});

test('updating patient does not change organization_id', function () {
    $this->actingAs($this->userA);

    $originalOrgId = $this->patientA->organization_id;

    $this->patientA->update([
        'first_name' => 'Updated',
    ]);

    expect($this->patientA->fresh()->organization_id)->toBe($originalOrgId);
});

test('unauthorized user cannot create patient', function () {
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
});
