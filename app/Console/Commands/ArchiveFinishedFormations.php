<?php

namespace App\Console\Commands;

use App\Enums\FormationStatus;
use App\Models\Formation;
use Illuminate\Console\Command;

class ArchiveFinishedFormations extends Command
{
    protected $signature = 'formations:archive-finished';
    protected $description = 'Archive formations that ended in the past';

    public function handle(): int
    {
        $count = Formation::query()
            ->whereNotNull('published_at')
            ->where('published_at', '<', now()->subMonths(6))
            ->update(['status' => FormationStatus::Archived->value]);

        $this->info('Archived formations: ' . $count);

        return self::SUCCESS;
    }
}
