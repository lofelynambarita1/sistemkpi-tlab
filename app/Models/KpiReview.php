<?php

// app/Models/KpiReview.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KpiReview extends Model
{
    protected $primaryKey = 'review_id';
    protected $fillable = ['kpi_id', 'reviewer_id', 'komentar', 'keputusan', 'review_date'];

    public function kpi()
    {
        return $this->belongsTo(Kpi::class, 'kpi_id', 'kpi_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id', 'user_id');
    }
}