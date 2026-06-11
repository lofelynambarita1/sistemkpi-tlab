<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Mapping koefisien untuk Continues Improvement
 */
class KpiContinuesImprovement extends Model
{
    protected $fillable = [
        'kpi_document_id', 'jenis_kegiatan_bukti', 'kegiatan',
        'mandays', 'koefisien', 'point', 'row_order',
    ];

    protected $casts = [
        'mandays'   => 'decimal:2',
        'koefisien' => 'decimal:4',
        'point'     => 'decimal:4',
    ];

    // Mapping jenis kegiatan → koefisien
    public static array $koefisienMap = [
        'Publikasi Jurnal Internasional'     => 2.0,
        'Publikasi Jurnal Nasional'          => 1.5,
        'Presentasi Konferensi Internasional'=> 1.5,
        'Presentasi Konferensi Nasional'     => 1.0,
        'Paten/HKI'                          => 2.0,
        'Inovasi Produk/Proses'              => 1.5,
        'Penulisan Buku/Modul'               => 1.0,
        'Riset Internal'                     => 1.0,
        'Lainnya'                            => 0.5,
    ];

    public function kpiDocument()
    {
        return $this->belongsTo(KpiDocument::class);
    }

    public function recalculate(): void
    {
        $this->koefisien = self::$koefisienMap[$this->jenis_kegiatan_bukti] ?? 0.5;
        $this->point     = $this->koefisien * $this->mandays;
    }
}
