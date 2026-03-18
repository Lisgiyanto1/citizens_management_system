<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SetDatabaseUser
{
    public function handle($request, Closure $next)
    {
        if ($user = auth()->user()) {

            DB::unprepared("
            SELECT set_config('app.user_id', '{$user->id}', false);
        ");

            DB::unprepared("
            SELECT set_config('app.user_role', '{$user->role}', false);
        ");
        }

        return $next($request);
    }
}