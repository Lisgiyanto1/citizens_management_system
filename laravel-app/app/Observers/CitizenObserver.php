<?php

namespace App\Observers;

use App\Models\Citizen;
use App\Services\ActivityLogService;

class CitizenObserver
{
    // Pastikan parameter ke-3 adalah objek Citizen
    protected function log($action, $message, Citizen $citizen)
    {
        app(ActivityLogService::class)->logActivity(
            $action,
            $message,
            Citizen::class,
            $citizen->id // Sekarang ini akan bekerja dengan benar
        );
    }

    public function created(Citizen $citizen): void
    {
        $this->log('CREATE', "Menambahkan warga baru: {$citizen->name}", $citizen);
    }

    public function updated(Citizen $citizen): void
    {
        // UBAH DARI $citizen->id MENJADI $citizen
        $this->log('UPDATE', "Memperbarui data warga: {$citizen->name}", $citizen);
    }

    public function deleted(Citizen $citizen): void
    {
        // UBAH DARI $citizen->id MENJADI $citizen
        $this->log('DELETE', "Menghapus data warga: {$citizen->name}", $citizen);
    }
}