<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KpiJobdesc extends Model
{
    protected $fillable = [
        'kpi_document_id',
        'penilaian_koefisien_ontime_onbudget',
        'penilaian_grade_project',
        'nama_kegiatan_bukti',
        'mandays_proyek',
        'jumlah_koefisien',
        'total_mandays_penugasan',
        'row_order',
    ];

    protected $casts = [
        'penilaian_koefisien_ontime_onbudget' => 'decimal:2',
        'penilaian_grade_project'             => 'decimal:2',
        'mandays_proyek'                      => 'decimal:2',
        'jumlah_koefisien'                    => 'decimal:2',
        'total_mandays_penugasan'             => 'decimal:2',
    ];

    public function kpiDocument()
    {
        return $this->belongsTo(KpiDocument::class);
    }

    /**
     * Calculate jumlah_koefisien from inputs
     * Jumlah = Koefisien Ontime OnBudget + Koefisien Grade Project
     */
    public function calculateJumlahKoefisien(): void
    {
        $this->jumlah_koefisien = $this->penilaian_koefisien_ontime_onbudget
                                + $this->penilaian_grade_project;
    }

    /**
     * Calculate total_mandays_penugasan
     * Total = Jumlah Koefisien * Mandays Proyek
     */
    public function calculateTotalMandays(): void
    {
        $this->total_mandays_penugasan = $this->jumlah_koefisien * $this->mandays_proyek;
    }

    public function recalculate(): void
    {
        $this->calculateJumlahKoefisien();
        $this->calculateTotalMandays();
    }
}
