<?php

namespace App\Jobs;

use App\Enums\TrainingSessionStatus;
use App\Models\TrainingSession;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class AutoArchiveSessions implements ShouldQueue
{
    use Queueable;

    public function handle(): void
    {
        TrainingSession::where('status', '!=', TrainingSessionStatus::FINISHED)
            ->where('end_date', '<', now())
            ->update(['status' => TrainingSessionStatus::FINISHED]);
    }
}
