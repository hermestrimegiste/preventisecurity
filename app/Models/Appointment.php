<?php

namespace App\Models;

use App\Traits\HasOrganizationScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Appointment extends Model
{
    use HasFactory, SoftDeletes, HasOrganizationScope;

    protected $fillable = [
        'organization_id',
        'patient_id',
        'doctor_id',
        'appointment_date',
        'duration_minutes',
        'status',
        'reason',
        'notes',
    ];

    protected $casts = [
        'appointment_date' => 'datetime',
        'duration_minutes' => 'integer',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function medicalRecord()
    {
        return $this->hasOne(MedicalRecord::class);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('appointment_date', '>=', now())
            ->where('status', 'scheduled')
            ->orderBy('appointment_date');
    }

    public function scopePast($query)
    {
        return $query->where('appointment_date', '<', now())
            ->orWhere('status', '!=', 'scheduled')
            ->orderBy('appointment_date', 'desc');
    }

    public function scopeForDoctor($query, $doctorId)
    {
        return $query->where('doctor_id', $doctorId);
    }

    public function scopeForPatient($query, $patientId)
    {
        return $query->where('patient_id', $patientId);
    }

    public function isUpcoming(): bool
    {
        return $this->appointment_date->isFuture() && $this->status === 'scheduled';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    public function isNoShow(): bool
    {
        return $this->status === 'no_show';
    }

    public function getEndTimeAttribute()
    {
        return $this->appointment_date->copy()->addMinutes($this->duration_minutes);
    }
}
