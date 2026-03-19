<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('citizens', function (Blueprint $table) {

            $table->dropColumn(['created_at', 'updated_at']);
        });

        Schema::table('citizens', function (Blueprint $table) {

            $table->timestamps();

            $table->uuid('created_by')->nullable()->change();
        });
    }

    public function down(): void
    {
        // Kembalikan ke asal jika perlu
    }
};