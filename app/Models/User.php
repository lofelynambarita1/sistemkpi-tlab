<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'employee_id', 'department',
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
        return in_array($this->role, ['associate', 'intermediate', 'senior', 'lead', 'principle']);
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
        return in_array($this->role, ['hr', 'manager']);
    }

    public function getRoleLabelAttribute(): string
    {
        return match($this->role) {
            'associate'    => 'Associate',
            'intermediate' => 'Intermediate',
            'senior'       => 'Senior',
            'lead'         => 'Lead',
            'principle'    => 'Principle',
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
}
