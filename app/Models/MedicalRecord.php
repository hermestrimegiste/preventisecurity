<?php

namespace App\Models;

use App\Traits\HasOrganizationScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicalRecord extends Model
{
    use HasFactory, SoftDeletes, HasOrganizationScope;

    protected $fillable = [
        'organization_id',
        'patient_id',
        'appointment_id',
        'doctor_id',
        'chief_complaint',
        'diagnosis',
        'examination_notes',
        'treatment_plan',
        'prescription',
        'lab_tests',
        'follow_up_instructions',
        'follow_up_date',
    ];

    protected $casts = [
        'follow_up_date' => 'date',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function scopeForPatient($query, $patientId)
    {
        return $query->where('patient_id', $patientId);
    }

    public function scopeForDoctor($query, $doctorId)
    {
        return $query->where('doctor_id', $doctorId);
    }

    public function scopeNeedsFollowUp($query)
    {
        return $query->whereNotNull('follow_up_date')
            ->where('follow_up_date', '>=', now())
            ->orderBy('follow_up_date');
    }

    public function hasDiagnosis(): bool
    {
        return !empty($this->diagnosis);
    }

    public function hasPrescription(): bool
    {
        return !empty($this->prescription);
    }

    public function hasLabTests(): bool
    {
        return !empty($this->lab_tests);
    }

    public function needsFollowUp(): bool
    {
        return !empty($this->follow_up_date) && $this->follow_up_date->isFuture();
    }
}
