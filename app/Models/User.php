<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'employee_id', 'department', 'jabatan', 'status_akun', 'atasan_id',
    ];

    protected $attributes = [
        'status_akun' => 'aktif',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Role checks
    public function isStaff(): bool
    {
        return in_array($this->role, ['associate', 'intermediate', 'senior', 'lead', 'principle', 'lead_hr']);
    }

    public function isHR(): bool
    {
        return $this->role === 'hr';
    }

    public function isManager(): bool
    {
        return $this->role === 'manager';
    }

    public function isHROrManager(): bool
    {
        return in_array($this->role, ['hr', 'lead_hr', 'manager']);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function getIsActiveAttribute(): bool
    {
        return ($this->status_akun ?? 'aktif') === 'aktif';
    }

    public function getRoleLabelAttribute(): string
    {
        return match($this->role) {
            'associate'    => 'Associate',
            'intermediate' => 'Intermediate',
            'senior'       => 'Senior',
            'lead'         => 'Lead',
            'principle'    => 'Principle',
            'lead_hr'      => 'Lead HR',
            'hr'           => 'HR',
            'manager'      => 'Manager',
            default        => ucfirst($this->role),
        };
    }

    // Relationships
    public function kpiDocuments()
    {
        return $this->hasMany(KpiDocument::class);
    }

    public function annualTargets()
    {
        return $this->hasMany(KpiAnnualTarget::class);
    }

    public function historyChanges()
    {
        return $this->hasMany(KpiDocumentHistory::class, 'changed_by');
    }

    public function atasan()
    {
        return $this->belongsTo(User::class, 'atasan_id');
    }

    public function bawahan()
    {
        return $this->hasMany(User::class, 'atasan_id');
    }

    public function getDivisiAttribute()
    {
        return $this->department;
    }

    public function setDivisiAttribute($value)
    {
        $this->attributes['department'] = $value;
    }
}
