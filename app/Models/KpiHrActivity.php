<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KpiHrActivity extends Model
{
    protected $fillable = [
        'kpi_document_id', 'jenis_kegiatan', 'kegiatan',
        'mandays', 'koefisien', 'point', 'row_order',
    ];

    protected $casts = [
        'mandays'   => 'decimal:2',
        'koefisien' => 'decimal:4',
        'point'     => 'decimal:4',
    ];

    public static array $koefisienMap = [
        'Rekrutmen / Seleksi'              => 1.5,
        'Pelatihan & Pengembangan'         => 1.5,
        'Evaluasi Kinerja'                 => 1.0,
        'Employee Engagement'              => 1.0,
        'Administrasi HR'                  => 0.5,
        'Hubungan Industrial'              => 1.5,
        'Kompensasi & Benefit'             => 1.0,
        'Keselamatan & Kesehatan Kerja'    => 1.0,
        'Budaya Perusahaan'                => 1.0,
        'Lainnya'                          => 0.5,
    ];

    public function kpiDocument()
    {
        return $this->belongsTo(KpiDocument::class);
    }

    public function recalculate(): void
    {
        $this->koefisien = self::$koefisienMap[$this->jenis_kegiatan] ?? 0.5;
        $this->point     = $this->koefisien * $this->mandays;
    }
}
