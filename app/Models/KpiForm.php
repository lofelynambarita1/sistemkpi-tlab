<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class KpiForm extends KpiDocument
{
    protected $table = 'kpi_forms';

    const STATUS_DRAFT         = 'draft';
    const STATUS_SUBMITTED     = 'submitted';
    const STATUS_WAITING_LEAD  = 'waiting_lead';
    const STATUS_WAITING_LHR   = 'waiting_lhr';
    const STATUS_WAITING_MGR   = 'waiting_mgr';
    const STATUS_NEED_REVISION = 'need_revision';
    const STATUS_REVIEWED      = 'reviewed';
    const STATUS_APPROVED      = 'approved';

    public function approvals(): HasMany
    {
        return $this->hasMany(KpiApproval::class, 'kpi_form_id');
    }
}
