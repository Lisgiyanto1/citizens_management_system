<?php

use App\Jobs\TestJob;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/session-test', function () {
    session(['name' => 'sofiyan']);
    return session('name');
});

Route::get('/queue-test', function () {
    TestJob::dispatch();
    return "Job Dispatched";
});
