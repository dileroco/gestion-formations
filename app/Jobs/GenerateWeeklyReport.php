<?php

namespace App\Jobs;

use App\Mail\WeeklyReportMail;
use App\Models\Inscription;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class GenerateWeeklyReport implements ShouldQueue
{
    use Queueable;

    public function handle(): void
    {
        $lastWeek = now()->subWeek();
        
        $stats = [
            'new_users' => User::where('created_at', '>=', $lastWeek)->count(),
            'new_inscriptions' => Inscription::where('created_at', '>=', $lastWeek)->count(),
            'confirmed_inscriptions' => Inscription::where('status', 'confirmed')
                ->where('updated_at', '>=', $lastWeek)->count(),
        ];

        $adminEmail = config('mail.from.address');
        Mail::to($adminEmail)->send(new WeeklyReportMail($stats));
    }
}
