<?php

namespace Database\Factories;

use App\Models\Appointment;
use App\Models\Organization;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MedicalRecordFactory extends Factory
{
    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
            'patient_id' => Patient::factory(),
            'appointment_id' => Appointment::factory(),
            'doctor_id' => User::factory(),
            'chief_complaint' => fake()->sentence(),
            'diagnosis' => fake()->optional()->sentence(),
            'examination_notes' => fake()->optional()->paragraph(),
            'treatment_plan' => fake()->optional()->paragraph(),
            'prescription' => fake()->optional()->paragraph(),
            'lab_tests' => fake()->optional()->sentence(),
            'follow_up_instructions' => fake()->optional()->paragraph(),
            'follow_up_date' => fake()->optional()->dateTimeBetween('+1 week', '+3 months'),
        ];
    }

    public function withFollowUp(): static
    {
        return $this->state(fn (array $attributes) => [
            'follow_up_date' => fake()->dateTimeBetween('+1 week', '+3 months'),
            'follow_up_instructions' => fake()->paragraph(),
        ]);
    }
}
