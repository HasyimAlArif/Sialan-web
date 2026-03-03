<?php

use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

// Monitor token
Artisan::command('token:monitor', function () {
    $total = DB::table('personal_access_tokens')->count();
    $expired = DB::table('personal_access_tokens')
        ->where('expires_at', '<', now())
        ->count();
    
    $this->info("Total tokens: {$total}");
    $this->info("Expired tokens: {$expired}");
    
    // Hapus yang expired
    if ($expired > 0) {
        $deleted = DB::table('personal_access_tokens')
            ->where('expires_at', '<', now())
            ->delete();
        $this->info("Deleted {$deleted} expired tokens");
    }
})->purpose('Monitor and clean tokens');

// Schedule
Schedule::command('sanctum:prune-expired --hours=24')->daily();
Schedule::command('token:monitor')->weekly();