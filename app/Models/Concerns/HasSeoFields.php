<?php

namespace App\Models\Concerns;

trait HasSeoFields
{
    public function getSeoTitleLocalizedAttribute(): ?string
    {
        $field = $this->seoTitleField();

        if ($this->isLocalizedSeoFields()) {
            return seo_title(localized_field($this, $field), $this->title ?? null);
        }

        return seo_title($this->{$field} ?? null, $this->title ?? null);
    }

    public function getMetaDescriptionLocalizedAttribute(): ?string
    {
        $field = $this->metaDescriptionField();

        if ($this->isLocalizedSeoFields()) {
            return localized_field($this, $field);
        }

        return $this->{$field} ?? null;
    }

    protected function seoTitleField(): string
    {
        return 'seo_title';
    }

    protected function metaDescriptionField(): string
    {
        return 'meta_description';
    }

    protected function isLocalizedSeoFields(): bool
    {
        return true;
    }
}
