<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KpiContinuousImprovement extends Model
{
    protected $fillable = [
        'kpi_form_id', 'jenis_kegiatan_bukti',
        'koefisien', 'kegiatan_ci', 'mandays_ci', 'point_ci',
    ];

    public static array $jenisOptions = [
        'Tidak didaftarkan pada Product & Research (tanpa perencanaan) – CI Belum Sesuai Format' => 0.125,
        'Tidak didaftarkan pada Product & Research (tanpa perencanaan) – CI Sesuai Format'       => 0.250,
        'Didaftarkan pada Product & Research, mendapat surat tugas dari Manajer – CI Individu'   => 0.750,
        'Didaftarkan pada Product & Research, mendapat surat tugas dari Manajer – menjadi Produk, Proyek, WI, SOP, atau CI Kolaborasi' => 1.000,
        'CI yang menjadi produk/proyek komersial atau CI yang terbukti menurunkan biaya operasional serta disetujui oleh Manajer'       => 1.250,
    ];

    public function kpiForm() { return $this->belongsTo(KpiForm::class); }

    public function recalculate(): void
    {
        $this->point_ci = $this->koefisien * $this->mandays_ci;
        $this->save();
    }
}