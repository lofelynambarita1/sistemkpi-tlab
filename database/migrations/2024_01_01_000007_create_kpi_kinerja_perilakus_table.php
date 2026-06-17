<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Penilaian Kinerja Perilaku - Form 2
        Schema::create('kpi_kinerja_perilakus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kpi_form_id')->constrained('kpi_forms')->onDelete('cascade');
            $table->string('aspek'); // nama aspek perilaku
            $table->text('deskripsi')->nullable();
            $table->decimal('nilai', 5, 2)->default(0);
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kpi_kinerja_perilakus');
    }
};