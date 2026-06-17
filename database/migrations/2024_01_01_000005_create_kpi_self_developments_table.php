<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kpi_self_developments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kpi_form_id')->constrained('kpi_forms')->onDelete('cascade');
            $table->string('jenis_kegiatan_sd');
            $table->decimal('koefisien_sd', 5, 3);
            $table->text('kegiatan_sd');
            $table->integer('mandays_sd');
            $table->decimal('point_sd', 10, 3)->default(0); // koefisien × mandays
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kpi_self_developments');
    }
};