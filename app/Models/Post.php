<?php

namespace App\Models;

use App\Enums\PostStatus;
use App\Models\Concerns\HasSeoFields;
use App\Models\Concerns\HasSlug;
use App\Models\Concerns\HasStatusBadge;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory, HasSlug, HasStatusBadge, HasSeoFields;

    protected $fillable = [
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
        'meta_description',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'status' => PostStatus::class,
    ];

    protected function slugFields(): array
    {
        return [
            'slug_fr' => 'title_fr',
            'slug_en' => 'title_en',
        ];
    }

    protected function statusBadges(): array
    {
        return [
            PostStatus::Draft->value => 'secondary',
            PostStatus::Published->value => 'success',
            PostStatus::Archived->value => 'dark',
        ];
    }

    protected function statusLabels(): array
    {
        return [
            PostStatus::Draft->value => 'Brouillon',
            PostStatus::Published->value => 'Publié',
            PostStatus::Archived->value => 'Archivé',
        ];
    }

    // Relations

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function getTitleAttribute(): ?string
    {
        return localized_field($this, 'title');
    }

    public function getSlugAttribute(): ?string
    {
        return localized_field($this, 'slug');
    }

    public function getContentAttribute(): ?string
    {
        return localized_field($this, 'content');
    }

    protected function isLocalizedSeoFields(): bool
    {
        return false;
    }
}
