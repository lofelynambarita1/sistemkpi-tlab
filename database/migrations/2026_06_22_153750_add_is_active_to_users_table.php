<?php
// database/migrations/xxxx_add_is_active_to_users_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_active')->default(true)->after('jabatan');
        });

        // Migrate data lama: status_akun → is_active
        DB::statement("UPDATE users SET is_active = CASE WHEN status_akun = 'aktif' THEN 1 ELSE 0 END");
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });
    }
};