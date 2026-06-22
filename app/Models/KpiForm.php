<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class KpiForm extends Model
{
    use SoftDeletes;

    protected $table = 'kpi_forms';

    protected $fillable = [
        'user_id',
        'current_approver_id',
        'status',
        'total_cuti',
        'hari_kerja_efektif',
        'target_jobdesc',
        'target_self_development',
        'target_hr_activity',
        'target_continuous_improvement',
        'target_total',
        'final_score_kinerja_hasil',
        'final_score_kinerja_perilaku',
        'final_kpi_score',
        'periode',
        'submitted_at',
    ];

    protected $casts = [
        'total_cuti'                         => 'integer',
        'hari_kerja_efektif'                 => 'integer',
        'target_jobdesc'                     => 'decimal:2',
        'target_self_development'            => 'decimal:2',
        'target_hr_activity'                 => 'decimal:2',
        'target_continuous_improvement'      => 'decimal:2',
        'target_total'                       => 'decimal:2',
        'final_score_kinerja_hasil'          => 'decimal:2',
        'final_score_kinerja_perilaku'       => 'decimal:2',
        'final_kpi_score'                    => 'decimal:2',
        'submitted_at'                       => 'datetime',
    ];

    const STATUS_DRAFT         = 'draft';
    const STATUS_SUBMITTED     = 'submitted';
    const STATUS_WAITING_LEAD  = 'waiting_lead';
    const STATUS_WAITING_LHR   = 'waiting_lhr';
    const STATUS_WAITING_MGR   = 'waiting_mgr';
    const STATUS_NEED_REVISION = 'need_revision';
    const STATUS_REVIEWED      = 'reviewed';
    const STATUS_APPROVED      = 'approved';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function currentApprover(): BelongsTo
    {
        return $this->belongsTo(User::class, 'current_approver_id');
    }

    public function approvals(): HasMany
    {
        return $this->hasMany(KpiApproval::class, 'kpi_form_id');
    }

    public function continuousImprovements(): HasMany
    {
        return $this->hasMany(KpiContinuousImprovement::class, 'kpi_form_id');
    }

    public static function getStatusLabel(?string $status): string
    {
        return match ($status) {
            self::STATUS_DRAFT         => 'Draft',
            self::STATUS_SUBMITTED     => 'Diajukan',
            self::STATUS_WAITING_LEAD  => 'Menunggu Lead',
            self::STATUS_WAITING_LHR   => 'Menunggu Lead HR',
            self::STATUS_WAITING_MGR   => 'Menunggu Manager',
            self::STATUS_NEED_REVISION => 'Perlu Revisi',
            self::STATUS_REVIEWED      => 'Ditinjau',
            self::STATUS_APPROVED      => 'Disetujui',
            default                    => ucfirst($status ?? ''),
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_DRAFT         => 'Draft',
            self::STATUS_SUBMITTED     => 'Diajukan',
            self::STATUS_WAITING_LEAD  => 'Menunggu Lead',
            self::STATUS_WAITING_LHR   => 'Menunggu Lead HR',
            self::STATUS_WAITING_MGR   => 'Menunggu Manager',
            self::STATUS_NEED_REVISION => 'Perlu Revisi',
            self::STATUS_REVIEWED      => 'Ditinjau',
            self::STATUS_APPROVED      => 'Disetujui',
            default                    => ucfirst($this->status),
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_DRAFT         => 'gray',
            self::STATUS_SUBMITTED     => 'info',
            self::STATUS_WAITING_LEAD,
            self::STATUS_WAITING_LHR,
            self::STATUS_WAITING_MGR   => 'warning',
            self::STATUS_NEED_REVISION => 'danger',
            self::STATUS_REVIEWED      => 'primary',
            self::STATUS_APPROVED      => 'success',
            default                    => 'gray',
        };
    }
}
