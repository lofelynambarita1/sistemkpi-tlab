<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class KpiBehaviorAssessment extends Model
{
    protected $fillable = [
        'kpi_document_id', 'aspek_perilaku', 'deskripsi',
        'nilai', 'bukti', 'urutan',
    ];
    public function kpiDocument()
    {
        return $this->belongsTo(KpiDocument::class);
    }
}
