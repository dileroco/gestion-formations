<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Formation extends Model
{
    protected $fillable = ["category_id" ,
    'title_fr',
    'title_en',
    'slug_fr',
    'slug_en',
    'short_description_fr',
    'short_description_en',
    'description_fr',
    'description_en',
    'image',
    'price',
    'duration',
    'level',
    'status',
    'published_at',
    'seo_title_fr',
    'seo_title_en',
    'meta_description_fr',
    'meta_description_en',
    ];
    public function category(){
        return $this->belongsTo(Category::class);
    }

public function training_sessions()
{
    return $this->hasMany(TrainingSession::class);
}
}

