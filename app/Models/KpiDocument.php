<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KpiDocument extends Model
{
    protected $fillable = [
        'user_id', 'period_year', 'status', 'total_score', 'notes', 'submitted_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'total_score'  => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function jobdescs(): HasMany
    {
        return $this->hasMany(KpiJobdesc::class)->orderBy('row_order');
    }

    public function continuesImprovements(): HasMany
    {
        return $this->hasMany(KpiContinuesImprovement::class)->orderBy('row_order');
    }

    public function selfDevelopments(): HasMany
    {
        return $this->hasMany(KpiSelfDevelopment::class)->orderBy('row_order');
    }

    public function hrActivities(): HasMany
    {
        return $this->hasMany(KpiHrActivity::class)->orderBy('row_order');
    }

    public function kinerjaPerilakus(): HasMany
    {
        return $this->hasMany(KpiKinerjaPerilaku::class)->orderBy('row_order');
    }

    public function histories(): HasMany
    {
        return $this->hasMany(KpiDocumentHistory::class)->orderBy('created_at', 'desc');
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'draft'     => 'Draft',
            'submitted' => 'Disubmit',
            'reviewed'  => 'Ditinjau',
            'approved'  => 'Disetujui',
            default     => ucfirst($this->status),
        };
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match($this->status) {
            'draft'     => 'badge-secondary',
            'submitted' => 'badge-warning',
            'reviewed'  => 'badge-info',
            'approved'  => 'badge-success',
            default     => 'badge-secondary',
        };
    }

    public function recalculateTotalScore(): void
    {
        $jobdescTotal = $this->jobdescs()->sum('total_mandays_penugasan');
        $ciTotal      = $this->continuesImprovements()->sum('point');
        $sdTotal      = $this->selfDevelopments()->sum('point');
        $hrTotal      = $this->hrActivities()->sum('point');
        $perilakuTotal = $this->kinerjaPerilakus()->sum('score');

        $this->total_score = $jobdescTotal + $ciTotal + $sdTotal + $hrTotal + $perilakuTotal;
        $this->save();
    }
}
