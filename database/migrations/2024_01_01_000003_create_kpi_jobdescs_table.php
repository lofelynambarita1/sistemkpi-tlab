<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kpi_jobdescs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kpi_document_id')->constrained()->onDelete('cascade');
            // Field input (4)
            $table->decimal('penilaian_koefisien_ontime_onbudget', 8, 2)->default(0)->comment('Penilaian Koefisien On Time dan On Budget');
            $table->decimal('penilaian_grade_project', 8, 2)->default(0)->comment('Penilaian Grade Project');
            $table->string('nama_kegiatan_bukti')->nullable()->comment('Nama Kegiatan dan Bukti');
            $table->decimal('mandays_proyek', 10, 2)->default(0)->comment('Mandays Proyek');
            // Field tidak dapat diubah (calculated, 2)
            $table->decimal('jumlah_koefisien', 8, 2)->default(0)->comment('Jumlah Koefisien Ontime OnBudget + Koefisien Grade Project');
            $table->decimal('total_mandays_penugasan', 10, 2)->default(0)->comment('Total Mandays Penugasan');
            $table->integer('row_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kpi_jobdescs');
    }
};
