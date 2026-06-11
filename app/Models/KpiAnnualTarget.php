<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KpiAnnualTarget extends Model
{
    protected $fillable = [
        'user_id', 'period_year',
        'target_jobdesc', 'target_continues_improvement', 'target_self_development',
        'target_hr_activity', 'target_kinerja_perilaku', 'target_total',
        'capaian_jobdesc', 'capaian_continues_improvement', 'capaian_self_development',
        'capaian_hr_activity', 'capaian_kinerja_perilaku', 'capaian_total',
    ];

    protected $casts = [
        'target_jobdesc'                  => 'decimal:2',
        'target_continues_improvement'    => 'decimal:2',
        'target_self_development'         => 'decimal:2',
        'target_hr_activity'              => 'decimal:2',
        'target_kinerja_perilaku'         => 'decimal:2',
        'target_total'                    => 'decimal:2',
        'capaian_jobdesc'                 => 'decimal:2',
        'capaian_continues_improvement'   => 'decimal:2',
        'capaian_self_development'        => 'decimal:2',
        'capaian_hr_activity'             => 'decimal:2',
        'capaian_kinerja_perilaku'        => 'decimal:2',
        'capaian_total'                   => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getPersentaseJobdescAttribute(): float
    {
        if ($this->target_jobdesc <= 0) return 0;
        return min(100, round(($this->capaian_jobdesc / $this->target_jobdesc) * 100, 1));
    }

    public function getPersentaseCIAttribute(): float
    {
        if ($this->target_continues_improvement <= 0) return 0;
        return min(100, round(($this->capaian_continues_improvement / $this->target_continues_improvement) * 100, 1));
    }

    public function getPersentaseSDAttribute(): float
    {
        if ($this->target_self_development <= 0) return 0;
        return min(100, round(($this->capaian_self_development / $this->target_self_development) * 100, 1));
    }

    public function getPersentaseHRAttribute(): float
    {
        if ($this->target_hr_activity <= 0) return 0;
        return min(100, round(($this->capaian_hr_activity / $this->target_hr_activity) * 100, 1));
    }

    public function getPersentasePerilakuAttribute(): float
    {
        if ($this->target_kinerja_perilaku <= 0) return 0;
        return min(100, round(($this->capaian_kinerja_perilaku / $this->target_kinerja_perilaku) * 100, 1));
    }

    public function getPersentaseTotalAttribute(): float
    {
        if ($this->target_total <= 0) return 0;
        return min(100, round(($this->capaian_total / $this->target_total) * 100, 1));
    }
}
