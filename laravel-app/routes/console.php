<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Schedule::call(function () {
//     $deletedCount = DB::table('activity_log')
//         ->where('created_at', '<', now()->subDay())
//         ->delete();

//     if ($deletedCount > 0) {
//         Log::info("System Cleanup: Berhasil menghapus {$deletedCount} log aktivitas lama.");
//     }
// })->daily();


Schedule::call(function () {
    // Menghapus log yang dibuat lebih dari 5 menit yang lalu 
    // (sesuaikan subMinute() dengan durasi yang Anda inginkan, 
    // misal: subMinutes(5) untuk menghapus data yang lebih tua dari 5 menit)
    $deletedCount = DB::table('activity_log')
        ->where('created_at', '<', now()->subMinutes(5)) 
        ->delete();

    if ($deletedCount > 0) {
        Log::info("System Cleanup: Berhasil menghapus {$deletedCount} log aktivitas lama.");
    }
})->everyFiveMinutes();