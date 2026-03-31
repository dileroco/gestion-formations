<?php

use Illuminate\Support\Str;

if (! function_exists('active_locale')) {
    function active_locale(): string
    {
        return app()->getLocale();
    }
}

if (! function_exists('localized_field')) {
    function localized_field(object $model, string $base, string $fallbackLocale = 'fr'): ?string
    {
        $locale = active_locale();
        $primary = $base . '_' . $locale;
        $fallback = $base . '_' . $fallbackLocale;

        return $model->{$primary}
            ?? $model->{$fallback}
            ?? null;
    }
}

if (! function_exists('format_price')) {
    function format_price(int|float $value, string $currency = 'MAD'): string
    {
        return number_format($value, 2, '.', ' ') . ' ' . $currency;
    }
}

if (! function_exists('seo_title')) {
    function seo_title(?string $custom, ?string $fallback = null): string
    {
        $fallbackValue = $fallback ?: config('app.name');

        return $custom ?: $fallbackValue;
    }
}

if (! function_exists('status_badge')) {
    function status_badge(string $status, array $map = []): string
    {
        if (! empty($map)) {
            return $map[$status] ?? 'secondary';
        }

        return 'secondary';
    }
}

if (! function_exists('short_uuid')) {
    function short_uuid(int $length = 8): string
    {
        return Str::upper(Str::random($length));
    }
}
