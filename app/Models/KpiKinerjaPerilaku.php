<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KpiKinerjaPerilaku extends Model
{
    protected $fillable = [
        'kpi_document_id', 'score', 'aspek_kinerja',
        'definisi', 'minimum_capaian', 'indikator', 'deskripsi', 'row_order',
    ];

    protected $casts = [
        'score'           => 'decimal:2',
        'minimum_capaian' => 'decimal:2',
    ];

    /**
     * Data master aspek kinerja perilaku yang sudah ditentukan (read-only)
     */
    public static function getMasterData(): array
    {
        return [
            [
                'aspek_kinerja'   => 'Integritas',
                'definisi'        => 'Kemampuan untuk bertindak jujur, konsisten, dan bertanggung jawab sesuai nilai dan etika perusahaan.',
                'minimum_capaian' => 70,
                'indikator'       => 'Kejujuran, Konsistensi, Akuntabilitas, Etika Kerja',
                'deskripsi'       => 'Karyawan menunjukkan perilaku jujur dan bertanggung jawab dalam setiap situasi kerja.',
            ],
            [
                'aspek_kinerja'   => 'Kolaborasi & Kerjasama Tim',
                'definisi'        => 'Kemampuan bekerja bersama rekan, berbagi informasi, dan mendukung pencapaian tujuan tim.',
                'minimum_capaian' => 70,
                'indikator'       => 'Komunikasi Aktif, Saling Mendukung, Fleksibilitas, Keterbukaan',
                'deskripsi'       => 'Karyawan secara aktif berkontribusi dalam kerja tim dan mendukung pencapaian target bersama.',
            ],
            [
                'aspek_kinerja'   => 'Inovasi & Kreativitas',
                'definisi'        => 'Kemampuan menghasilkan ide baru, solusi kreatif, dan pendekatan yang meningkatkan efisiensi.',
                'minimum_capaian' => 65,
                'indikator'       => 'Inisiatif, Problem Solving Kreatif, Adaptasi Perubahan, Implementasi Ide',
                'deskripsi'       => 'Karyawan aktif mengusulkan dan mengimplementasikan inovasi dalam pekerjaan sehari-hari.',
            ],
            [
                'aspek_kinerja'   => 'Orientasi pada Hasil',
                'definisi'        => 'Kemampuan fokus pada target, menyelesaikan pekerjaan tepat waktu dengan kualitas yang baik.',
                'minimum_capaian' => 75,
                'indikator'       => 'Ketepatan Waktu, Kualitas Output, Efisiensi, Persistensi',
                'deskripsi'       => 'Karyawan selalu berupaya mencapai dan melampaui target yang ditetapkan.',
            ],
            [
                'aspek_kinerja'   => 'Pengembangan Diri & Pembelajaran',
                'definisi'        => 'Keinginan dan kemampuan untuk terus belajar, berkembang, dan meningkatkan kompetensi.',
                'minimum_capaian' => 65,
                'indikator'       => 'Proaktif Belajar, Penerapan Ilmu Baru, Mentoring, Berbagi Pengetahuan',
                'deskripsi'       => 'Karyawan secara proaktif mencari peluang pengembangan dan menerapkan pembelajaran baru.',
            ],
        ];
    }

    public function kpiDocument()
    {
        return $this->belongsTo(KpiDocument::class);
    }
}
