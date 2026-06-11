<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kpi_document_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kpi_document_id')->constrained()->onDelete('cascade');
            $table->foreignId('changed_by')->constrained('users')->onDelete('cascade');
            $table->string('action')->comment('update, delete, status_change, submit');
            $table->string('section')->nullable()->comment('jobdesc, continues_improvement, self_development, hr_activity, kinerja_perilaku, document');
            $table->json('old_data')->nullable();
            $table->json('new_data')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kpi_document_histories');
    }
};
