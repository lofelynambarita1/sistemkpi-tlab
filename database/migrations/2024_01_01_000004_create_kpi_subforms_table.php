<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Continues Improvement
        Schema::create('kpi_continues_improvements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kpi_document_id')->constrained()->onDelete('cascade');
            // Field input (3)
            $table->string('jenis_kegiatan_bukti')->nullable()->comment('Jenis Kegiatan / Bukti');
            $table->string('kegiatan')->nullable();
            $table->decimal('mandays', 10, 2)->default(0);
            // Field tidak dapat diubah (2)
            $table->decimal('koefisien', 8, 4)->default(0)->comment('Calculated from jenis_kegiatan_bukti');
            $table->decimal('point', 10, 4)->default(0)->comment('Calculated from koefisien * mandays');
            $table->integer('row_order')->default(0);
            $table->timestamps();
        });

        // Self Development
        Schema::create('kpi_self_developments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kpi_document_id')->constrained()->onDelete('cascade');
            // Field input (3)
            $table->string('jenis_sd')->nullable()->comment('Jenis SD');
            $table->string('kegiatan')->nullable();
            $table->decimal('mandays', 10, 2)->default(0);
            // Field tidak dapat diubah (2)
            $table->decimal('koefisien', 8, 4)->default(0)->comment('Calculated from jenis_sd');
            $table->decimal('point', 10, 4)->default(0)->comment('Calculated from koefisien * mandays');
            $table->integer('row_order')->default(0);
            $table->timestamps();
        });

        // HR Activity
        Schema::create('kpi_hr_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kpi_document_id')->constrained()->onDelete('cascade');
            // Field input (3)
            $table->string('jenis_kegiatan')->nullable();
            $table->string('kegiatan')->nullable();
            $table->decimal('mandays', 10, 2)->default(0);
            // Field tidak dapat diubah (2)
            $table->decimal('koefisien', 8, 4)->default(0)->comment('Calculated from jenis_kegiatan');
            $table->decimal('point', 10, 4)->default(0)->comment('Calculated from koefisien * mandays');
            $table->integer('row_order')->default(0);
            $table->timestamps();
        });

        // Kinerja Perilaku
        Schema::create('kpi_kinerja_perilakus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kpi_document_id')->constrained()->onDelete('cascade');
            // Field input (1)
            $table->decimal('score', 8, 2)->default(0);
            // Field tidak dapat diubah (5)
            $table->string('aspek_kinerja')->nullable();
            $table->text('definisi')->nullable();
            $table->decimal('minimum_capaian', 8, 2)->default(0);
            $table->text('indikator')->nullable();
            $table->text('deskripsi')->nullable();
            $table->integer('row_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kpi_kinerja_perilakus');
        Schema::dropIfExists('kpi_hr_activities');
        Schema::dropIfExists('kpi_self_developments');
        Schema::dropIfExists('kpi_continues_improvements');
    }
};
