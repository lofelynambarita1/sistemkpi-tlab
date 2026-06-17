<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kpi_continuous_improvements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kpi_form_id')->constrained('kpi_forms')->onDelete('cascade');
            $table->string('jenis_kegiatan_bukti'); // label pilihan
            $table->decimal('koefisien', 5, 3);
            $table->text('kegiatan_ci');
            $table->integer('mandays_ci');
            $table->decimal('point_ci', 10, 3)->default(0); // koefisien × mandays
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kpi_continuous_improvements');
    }
};