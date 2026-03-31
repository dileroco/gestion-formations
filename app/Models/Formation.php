<?php

namespace App\Models;

use App\Enums\FormationStatus;
use App\Models\Concerns\HasSeoFields;
use App\Models\Concerns\HasSlug;
use App\Models\Concerns\HasStatusBadge;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formation extends Model
{
    use HasFactory, HasSlug, HasStatusBadge, HasSeoFields;

    protected $fillable = [
        'user_id',
        'category_id',
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

    protected $casts = [
        'published_at' => 'datetime',
        'price' => 'decimal:2',
        'status' => FormationStatus::class,
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
            FormationStatus::Draft->value => 'secondary',
            FormationStatus::Published->value => 'success',
            FormationStatus::Archived->value => 'dark',
        ];
    }

    protected function statusLabels(): array
    {
        return [
            FormationStatus::Draft->value => 'Brouillon',
            FormationStatus::Published->value => 'Publié',
            FormationStatus::Archived->value => 'Archivé',
        ];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function trainingSessions()
    {
        return $this->hasMany(TrainingSession::class);
    }

    public function trainer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function user()
    {
        return $this->trainer();
    }

    public function getTitleAttribute(): ?string
    {
        return localized_field($this, 'title');
    }

    public function getSlugAttribute(): ?string
    {
        return localized_field($this, 'slug');
    }

    public function getShortDescriptionAttribute(): ?string
    {
        return localized_field($this, 'short_description');
    }

    public function getDescriptionAttribute(): ?string
    {
        return localized_field($this, 'description');
    }

    protected function seoTitleField(): string
    {
        return 'seo_title';
    }

    protected function metaDescriptionField(): string
    {
        return 'meta_description';
    }
}
