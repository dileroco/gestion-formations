<?php

namespace App\Models;

use App\Enums\InscriptionStatus;
use App\Models\Concerns\HasStatusBadge;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscription extends Model
{
    use HasFactory, HasStatusBadge;

    protected $fillable = [
        'user_id',
        'session_id',
        'reference',
        'status',
        'note',
        'confirmed_at',
        'cancelled_at',
    ];

    protected $casts = [
        'confirmed_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'status' => InscriptionStatus::class,
    ];

    protected function statusBadges(): array
    {
        return [
            InscriptionStatus::Pending->value => 'warning',
            InscriptionStatus::Confirmed->value => 'success',
            InscriptionStatus::Cancelled->value => 'danger',
        ];
    }

    protected function statusLabels(): array
    {
        return [
            InscriptionStatus::Pending->value => 'En attente',
            InscriptionStatus::Confirmed->value => 'Confirmée',
            InscriptionStatus::Cancelled->value => 'Annulée',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function trainingSession()
    {
        return $this->belongsTo(TrainingSession::class, 'session_id');
    }

    public function session()
    {
        return $this->trainingSession();
    }
}
