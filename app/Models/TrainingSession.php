<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingSession extends Model
{
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


    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }


    public function trainer()
    {
        return $this->belongsTo(User::class, 'trainer_id');
    }
}