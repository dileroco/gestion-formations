<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inscription extends Model
{
    protected $fillable = [
        'user_id',
        'session_id',
        'reference',
        'status',
        'note',
        'confirmed_at',
        'cancelled_at'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function session(){
        return $this->belongsTo(TrainingSession::class , 'session_id');
    }
}
