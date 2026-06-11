<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KpiSelfDevelopment extends Model
{
    protected $fillable = [
        'kpi_document_id', 'jenis_sd', 'kegiatan',
        'mandays', 'koefisien', 'point', 'row_order',
    ];

    protected $casts = [
        'mandays'   => 'decimal:2',
        'koefisien' => 'decimal:4',
        'point'     => 'decimal:4',
    ];

    public static array $koefisienMap = [
        'Pelatihan Teknis Bersertifikat Internasional' => 2.0,
        'Pelatihan Teknis Bersertifikat Nasional'      => 1.5,
        'Pelatihan Teknis Non-Sertifikat'              => 1.0,
        'Seminar/Workshop Internasional'               => 1.5,
        'Seminar/Workshop Nasional'                    => 1.0,
        'Kursus Online (Berbayar)'                     => 1.0,
        'Kursus Online (Gratis)'                       => 0.5,
        'Studi Mandiri / Autodidak'                    => 0.5,
        'Mentoring/Coaching'                           => 1.0,
        'Lainnya'                                      => 0.5,
    ];

    public function kpiDocument()
    {
        return $this->belongsTo(KpiDocument::class);
    }

    public function recalculate(): void
    {
        $this->koefisien = self::$koefisienMap[$this->jenis_sd] ?? 0.5;
        $this->point     = $this->koefisien * $this->mandays;
    }
}
