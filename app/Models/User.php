<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'employee_id',
        'department',
        'jabatan',
        'atasan_id',
        'is_active',
        // Kolom role string lama — tetap ada untuk backward compatibility
        // sampai semua fitur lain sudah migrasi ke Spatie roles
        'role',
        'status_akun',
    ];

    protected $attributes = [
        'is_active'   => true,
        'status_akun' => 'aktif', // legacy — biarkan dulu
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'is_active'         => 'boolean',
        ];
    }

    // ─── Scope ───────────────────────────────────────────────
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // ─── Role Checks (pakai Spatie, bukan kolom string) ──────
    public function isAdmin(): bool
    {
        return $this->hasRole(['admin', 'super_admin']);
    }

    public function isManager(): bool
    {
        return $this->hasRole('manager');
    }

    public function isLead(): bool
    {
        return $this->hasRole(['lead', 'lead_hr']);
    }

    public function isPrincipal(): bool
    {
        return $this->hasRole('principal');
    }

    public function isEmployee(): bool
    {
        return $this->hasRole(['associate', 'intermediate', 'senior']);
    }

    public function isStaff(): bool
    {
        return $this->hasRole(['associate', 'intermediate', 'senior', 'lead', 'principle', 'lead_hr']);
    }

    public function isHROrManager(): bool
    {
        return $this->hasRole(['lead_hr', 'manager', 'hr']);
    }

    public function gradeProjectCoefficient(string $grade): float
    {
        return match ($grade) {
            'A' => 2.0,
            'B' => 1.0,
            'C' => 0.5,
            default => 0,
        };
    }

    // ─── Accessor ────────────────────────────────────────────
    public function getDivisiAttribute(): ?string
    {
        return $this->department;
    }

    public function setDivisiAttribute($value): void
    {
        $this->attributes['department'] = $value;
    }

    public function getRoleLabelAttribute(): string
    {
        $role = $this->roles->first();
        return $role ? ucfirst(str_replace('_', ' ', $role->name)) : '-';
    }

    // ─── Relationships ────────────────────────────────────────
    public function atasan()
    {
        return $this->belongsTo(User::class, 'atasan_id');
    }

    public function bawahan()
    {
        return $this->hasMany(User::class, 'atasan_id');
    }

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