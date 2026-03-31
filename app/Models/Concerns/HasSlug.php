<?php

namespace App\Models\Concerns;

use Illuminate\Support\Str;

trait HasSlug
{
    protected static function bootHasSlug(): void
    {
        static::saving(function ($model) {
            foreach ($model->slugFields() as $slugField => $sourceField) {
                $sourceValue = $model->{$sourceField} ?? null;
                $currentSlug = $model->{$slugField} ?? null;

                if (empty($currentSlug) && !empty($sourceValue)) {
                    $model->{$slugField} = Str::slug($sourceValue);
                }
            }
        });
    }

    /**
     * Return an array of slugField => sourceField.
     *
     * @return array<string, string>
     */
    abstract protected function slugFields(): array;
}
