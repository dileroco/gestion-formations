<?php

namespace App\Models;

use App\Enums\SessionMode;
use App\Enums\TrainingSessionStatus;
use App\Models\Concerns\HasStatusBadge;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingSession extends Model
{
    use HasFactory, HasStatusBadge;

    protected $table = 'training_sessions';

    protected $fillable = [
        'formation_id',
        'trainer_id',
        'start_date',
        'end_date',
        'capacity',
        'mode',
        'city',
        'meeting_link',
        'status',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'mode' => SessionMode::class,
        'status' => TrainingSessionStatus::class,
    ];

    protected function statusBadges(): array
    {
        return [
            TrainingSessionStatus::Upcoming->value => 'info',
            TrainingSessionStatus::Ongoing->value => 'success',
            TrainingSessionStatus::Finished->value => 'secondary',
        ];
    }

    protected function statusLabels(): array
    {
        return [
            TrainingSessionStatus::Upcoming->value => 'À venir',
            TrainingSessionStatus::Ongoing->value => 'En cours',
            TrainingSessionStatus::Finished->value => 'Terminée',
        ];
    }

    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }

    public function trainer()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }

    public function inscriptions()
    {
        return $this->hasMany(Inscription::class, 'session_id');
    }

    public function participants()
    {
        return $this->belongsToMany(User::class, 'inscriptions', 'session_id', 'user_id');
    }
}
