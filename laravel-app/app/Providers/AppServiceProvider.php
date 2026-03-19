<?php

namespace App\Providers;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public function boot(): void
    {
        Event::listen(Login::class, function ($event) {
            app(\App\Services\ActivityLogService::class)->logActivity(
                'LOGIN',
                "User {$event->user->name} berhasil login"
            );
        });

        Event::listen(Logout::class, function ($event) {
            app(\App\Services\ActivityLogService::class)->logActivity(
                'LOGOUT',
                "User {$event->user->name} logout"
            );
        });
    }
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

}
