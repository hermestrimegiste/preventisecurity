<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMedicalRecordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('edit medical records');
    }

    public function rules(): array
    {
        return [
            'chief_complaint' => ['sometimes', 'required', 'string', 'max:1000'],
            'diagnosis' => ['nullable', 'string', 'max:1000'],
            'examination_notes' => ['nullable', 'string', 'max:2000'],
            'treatment_plan' => ['nullable', 'string', 'max:2000'],
            'prescription' => ['nullable', 'string', 'max:2000'],
            'lab_tests' => ['nullable', 'string', 'max:1000'],
            'follow_up_instructions' => ['nullable', 'string', 'max:1000'],
            'follow_up_date' => ['nullable', 'date', 'after:today'],
        ];
    }

    public function attributes(): array
    {
        return [
            'chief_complaint' => 'chief complaint',
            'examination_notes' => 'examination notes',
            'treatment_plan' => 'treatment plan',
            'lab_tests' => 'lab tests',
            'follow_up_instructions' => 'follow-up instructions',
            'follow_up_date' => 'follow-up date',
        ];
    }
}
