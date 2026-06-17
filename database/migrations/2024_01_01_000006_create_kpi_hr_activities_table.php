<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kpi_hr_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kpi_form_id')->constrained('kpi_forms')->onDelete('cascade');
            $table->string('jenis_kegiatan_hra');
            $table->decimal('koefisien_hra', 5, 3);
            $table->text('kegiatan_hra');
            $table->integer('mandays_hra');
            $table->decimal('point_hra', 10, 3)->default(0); // koefisien × mandays
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kpi_hr_activities');
    }
};