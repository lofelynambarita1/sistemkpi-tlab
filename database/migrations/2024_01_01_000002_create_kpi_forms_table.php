<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kpi_forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('current_approver_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('status')->default('draft');
            $table->integer('total_cuti')->default(0);
            $table->integer('hari_kerja_efektif')->default(240);
            // Target Points (calculated)
            $table->decimal('target_jobdesc', 10, 2)->default(0);
            $table->decimal('target_self_development', 10, 2)->default(0);
            $table->decimal('target_hr_activity', 10, 2)->default(0);
            $table->decimal('target_continuous_improvement', 10, 2)->default(0);
            $table->decimal('target_total', 10, 2)->default(0);
            // Final Scores
            $table->decimal('final_score_kinerja_hasil', 10, 2)->default(0);
            $table->decimal('final_score_kinerja_perilaku', 10, 2)->default(0);
            $table->decimal('final_kpi_score', 10, 2)->default(0);
            $table->string('periode')->nullable(); // e.g. "2024"
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kpi_forms');
    }
};