<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'current_organization_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's organizations.
     */
    public function organizations()
    {
        return $this->belongsToMany(Organization::class, 'organization_user')
            ->withTimestamps();
    }

    /**
     * Get the user's current organization.
     */
    public function currentOrganization()
    {
        return $this->belongsTo(Organization::class, 'current_organization_id');
    }

    /**
     * Get the user's appointments.
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'doctor_id');
    }

    /**
     * Get the user's medical records.
     */
    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class, 'doctor_id');
    }

    /**
     * Switch the user's current organization.
     *
     * @param int $organizationId
     * @return bool
     */
    public function switchOrganization(int $organizationId): bool
    {
        if ($this->organizations->contains($organizationId)) {
            $this->current_organization_id = $organizationId;
            return $this->save();
        }
        return false;
    }

    /**
     * Check if the user belongs to an organization.
     *
     * @param int $organizationId
     * @return bool
     */
    public function belongsToOrganization(int $organizationId): bool
    {
        return $this->organizations->contains($organizationId);
    }

    /**
     * Check if the user has multiple organizations.
     *
     * @return bool
     */
    public function hasMultipleOrganizations(): bool
    {
        return $this->organizations()->count() > 1;
    }

    /**
     * Get the user's role names.
     *
     * @return array
     */
    public function getRoleNamesAttribute(): array
    {
        return $this->roles->pluck('name')->toArray();
    }

    /**
     * Check if the user is an admin.
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    /**
     * Check if the user is a doctor.
     *
     * @return bool
     */
    public function isDoctor(): bool
    {
        return $this->hasRole('doctor');
    }
}
