<?php

namespace App\Console\Commands;

use App\Models\TrainingSession;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendSessionReminder extends Command
{
    protected $signature = 'sessions:send-reminders';
    protected $description = 'Send reminders two days before sessions start';

    public function handle(): int
    {
        $targetDate = now()->addDays(2)->startOfDay();

        $sessions = TrainingSession::query()
            ->whereBetween('start_date', [$targetDate, $targetDate->copy()->endOfDay()])
            ->get();

        foreach ($sessions as $session) {
            Log::info('Reminder scheduled', [
                'session_id' => $session->id,
                'start_date' => $session->start_date,
            ]);
        }

        $this->info('Reminders processed: ' . $sessions->count());

        return self::SUCCESS;
    }
}
