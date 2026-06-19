<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KpiApproval extends Model
{
    protected $fillable = [
        'kpi_form_id', 'actor_id', 'action', 'komentar', 'acted_at',
    ];

    protected $casts = [
        'acted_at' => 'datetime',
    ];

    public $timestamps = true;

    public function form(): BelongsTo
    {
        return $this->belongsTo(KpiForm::class, 'kpi_form_id');
    }

    public function actor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'actor_id');
    }
}
