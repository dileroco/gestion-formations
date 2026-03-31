<?php

namespace App\Enums;

enum TrainingSessionStatus: string
{
    case Upcoming = 'upcoming';
    case Ongoing = 'ongoing';
    case Finished = 'finished';

    public function label(): string
    {
        return match($this) {
            self::Upcoming => 'À venir',
            self::Ongoing => 'En cours',
            self::Finished => 'Terminée',
        };
    }
}
