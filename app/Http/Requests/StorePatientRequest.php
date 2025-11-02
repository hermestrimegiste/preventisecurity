<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePatientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('create patients');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'date_of_birth' => ['required', 'date', 'before:today'],
            'gender' => ['required', 'in:male,female,other'],
            'email' => ['nullable', 'email', 'max:255', 'unique:patients,email,NULL,id,organization_id,' . $this->user()->current_organization_id],
            'phone' => ['required', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
            'city' => ['nullable', 'string', 'max:255'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'country' => ['nullable', 'string', 'max:100'],
            'emergency_contact_name' => ['nullable', 'string', 'max:255'],
            'emergency_contact_phone' => ['nullable', 'string', 'max:20'],
            'occupation' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'blood_type' => ['nullable', 'string', 'in:A+,A-,B+,B-,AB+,AB-,O+,O-'],
            'allergies' => ['nullable', 'string', 'max:1000'],
            'medications' => ['nullable', 'string', 'max:1000'],
            'organization_id' => ['required', 'exists:organizations,id', 'in:' . $this->user()->current_organization_id],
        ];
    }

    /**
     * Get custom attribute names for validator errors.
     */
    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'first_name' => 'prénom',
            'last_name' => 'nom',
            'date_of_birth' => 'date de naissance',
            'emergency_contact_name' => 'nom du contact d\'urgence',
            'emergency_contact_phone' => 'téléphone du contact d\'urgence',
            'blood_type' => 'groupe sanguin',
            'postal_code' => 'code postal',
            'blood_group' => 'blood group',
        ];
    }
}
