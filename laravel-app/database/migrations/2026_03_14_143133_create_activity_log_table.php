<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('activity_log', function (Blueprint $table) {
            $table->uuid('id')
                ->primary()
                ->default(DB::raw('gen_random_uuid()'));
            $table->uuid('user_id')
                ->index();
            $table->string('action', 120);
            $table->text('description')
                ->nullable();
            $table->string('subject_tytpe', 100)
                ->nullable();
            $table->unsignedBigInteger('subject_id')
                ->nullable();
            $table->timestamp('created_at')
                ->nullable();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_log');
    }
};
