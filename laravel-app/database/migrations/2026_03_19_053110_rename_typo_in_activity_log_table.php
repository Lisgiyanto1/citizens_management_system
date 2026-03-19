<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('activity_log', function (Blueprint $table) {
            // Rename kolom subject_tytpe menjadi subject_type
            $table->renameColumn('subject_tytpe', 'subject_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('activity_log', function (Blueprint $table) {
            // Kembalikan ke typo jika ingin rollback
            $table->renameColumn('subject_type', 'subject_tytpe');
        });
    }
};