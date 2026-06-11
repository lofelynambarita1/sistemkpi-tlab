<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KpiDocumentHistory extends Model
{
    protected $fillable = [
        'kpi_document_id', 'changed_by', 'action', 'section',
        'old_data', 'new_data', 'description',
    ];

    protected $casts = [
        'old_data' => 'array',
        'new_data' => 'array',
    ];

    public function kpiDocument()
    {
        return $this->belongsTo(KpiDocument::class);
    }

    public function changedBy()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }

    public function getActionLabelAttribute(): string
    {
        return match($this->action) {
            'create'        => 'Dibuat',
            'update'        => 'Diperbarui',
            'delete'        => 'Dihapus',
            'submit'        => 'Disubmit',
            'status_change' => 'Status Diubah',
            default         => ucfirst($this->action),
        };
    }

    public function getActionBadgeClassAttribute(): string
    {
        return match($this->action) {
            'create'        => 'badge-success',
            'update'        => 'badge-warning',
            'delete'        => 'badge-danger',
            'submit'        => 'badge-primary',
            'status_change' => 'badge-info',
            default         => 'badge-secondary',
        };
    }

    public function getSectionLabelAttribute(): string
    {
        return match($this->section) {
            'jobdesc'               => 'Jobdesc',
            'continues_improvement' => 'Continues Improvement',
            'self_development'      => 'Self Development',
            'hr_activity'           => 'HR Activity',
            'kinerja_perilaku'      => 'Kinerja Perilaku',
            'document'              => 'Dokumen',
            default                 => ucfirst($this->section ?? ''),
        };
    }
}
