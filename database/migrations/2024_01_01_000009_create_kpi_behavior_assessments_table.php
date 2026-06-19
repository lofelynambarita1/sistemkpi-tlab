<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kpi_behavior_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kpi_document_id')->constrained('kpi_documents')->cascadeOnDelete();
            $table->string('aspek_perilaku');
            $table->text('deskripsi')->nullable();
            $table->unsignedTinyInteger('nilai')->default(0);
            $table->text('bukti')->nullable();
            $table->integer('urutan')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kpi_behavior_assessments');
    }
};
