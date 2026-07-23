<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/*
|--------------------------------------------------------------------------
| Scheduled Tasks
|--------------------------------------------------------------------------
*/

// Tandai rental overdue setiap hari pukul 00:05
Schedule::command('rentals:mark-overdue')->dailyAt('00:05');

// Bersihkan log kunjungan lama (> 90 hari) dan log aktivitas lama (> 90 hari) setiap hari pukul 00:10 WIB (Jam Sepi)
Schedule::command('model:prune', [
    '--model' => [
        \App\Models\VisitorLog::class,
        \App\Models\ActivityLog::class,
    ],
])->dailyAt('00:10');
