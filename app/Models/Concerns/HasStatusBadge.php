<?php

namespace App\Models\Concerns;

trait HasStatusBadge
{
    public function getStatusBadgeAttribute(): string
    {
        $map = $this->statusBadges();
        $status = $this->status instanceof \BackedEnum ? $this->status->value : (string) ($this->status ?? '');

        return $map[$status] ?? 'secondary';
    }

    public function getStatusLabelAttribute(): string
    {
        $map = $this->statusLabels();
        $status = $this->status instanceof \BackedEnum ? $this->status->value : (string) ($this->status ?? '');

        return $map[$status] ?? $status;
    }

    /**
     * @return array<string, string>
     */
    abstract protected function statusBadges(): array;

    /**
     * @return array<string, string>
     */
    abstract protected function statusLabels(): array;
}
