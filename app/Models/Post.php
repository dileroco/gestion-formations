<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable([
    'category_id',
    'author_id',
    'title_fr',
    'title_en',
    'slug_fr',
    'slug_en',
    'content_fr',
    'content_en',
    'status',
    'published_at',
    'seo_title',
    'meta_description'
])]
class Post extends Model
{
    // Table is "posts" by default, no need to declare

    // Relations

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}