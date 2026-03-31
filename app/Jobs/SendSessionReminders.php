<?php

namespace App\Jobs;

use App\Mail\SessionReminderMail;
use App\Models\TrainingSession;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendSessionReminders implements ShouldQueue
{
    use Queueable;

    public function handle(): void
    {
        $tomorrow = now()->addDay()->startOfHour();
        
        $sessions = TrainingSession::where('status', 'upcoming')
            ->where('start_date', '>=', $tomorrow)
            ->where('start_date', '<', $tomorrow->copy()->addHour())
            ->with('participants')
            ->get();

        foreach ($sessions as $session) {
            foreach ($session->participants as $participant) {
                Mail::to($participant->email)->queue(new SessionReminderMail($session, $participant));
            }
        }
    }
}
