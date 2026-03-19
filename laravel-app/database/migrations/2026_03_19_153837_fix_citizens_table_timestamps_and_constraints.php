<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Gunakan Schema::table, BUKAN Schema::create
        Schema::table('citizens', function (Blueprint $table) {
            // Drop kolom lama agar tidak bentrok
            $table->dropColumn(['created_at', 'updated_at']);
        });

        Schema::table('citizens', function (Blueprint $table) {
            // Tambahkan kembali dengan helper standar
            $table->timestamps();

            // Pastikan created_by nullable (jika RLS/Policy mengizinkan)
            $table->uuid('created_by')->nullable()->change();
        });
    }

    public function down(): void
    {
        // Kembalikan ke asal jika perlu
    }
};