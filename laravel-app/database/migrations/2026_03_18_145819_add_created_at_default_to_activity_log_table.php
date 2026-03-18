<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Step 1: update data lama
        DB::table('activity_log')
            ->whereNull('created_at')
            ->update(['created_at' => DB::raw('CURRENT_TIMESTAMP')]);

        // Step 2: ubah kolom
        Schema::table('activity_log', function (Blueprint $table) {
            $table->timestamp('created_at')
                ->default(DB::raw('CURRENT_TIMESTAMP'))
                ->nullable(false) // sekarang aman karena semua baris sudah ada
                ->change();
        });
    }

    public function down(): void
    {
        Schema::table('activity_log', function (Blueprint $table) {
            $table->timestamp('created_at')
                ->nullable()
                ->default(null)
                ->change();
        });
    }
};

