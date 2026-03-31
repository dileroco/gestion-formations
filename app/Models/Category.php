<?php

namespace App\Models;

use App\Models\Concerns\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'name_en',
        'name_fr',
        'slug_en',
        'slug_fr',
    ];

    protected function slugFields(): array
    {
        return [
            'slug_fr' => 'name_fr',
            'slug_en' => 'name_en',
        ];
    }

    public function formations()
    {
        return $this->hasMany(Formation::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function getNameAttribute(): ?string
    {
        return localized_field($this, 'name');
    }

    public function getSlugAttribute(): ?string
    {
        return localized_field($this, 'slug');
    }
}
