<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kpi_annual_targets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('period_year', 4);
            $table->decimal('target_jobdesc', 8, 2)->default(0);
            $table->decimal('target_continues_improvement', 8, 2)->default(0);
            $table->decimal('target_self_development', 8, 2)->default(0);
            $table->decimal('target_hr_activity', 8, 2)->default(0);
            $table->decimal('target_kinerja_perilaku', 8, 2)->default(0);
            $table->decimal('target_total', 8, 2)->default(0);
            $table->decimal('capaian_jobdesc', 8, 2)->default(0);
            $table->decimal('capaian_continues_improvement', 8, 2)->default(0);
            $table->decimal('capaian_self_development', 8, 2)->default(0);
            $table->decimal('capaian_hr_activity', 8, 2)->default(0);
            $table->decimal('capaian_kinerja_perilaku', 8, 2)->default(0);
            $table->decimal('capaian_total', 8, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kpi_annual_targets');
    }
};
