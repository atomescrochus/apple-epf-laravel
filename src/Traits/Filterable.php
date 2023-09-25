<?php

namespace Appwapp\EPF\Traits;

use Illuminate\Support\Collection;

trait Filterable
{
    /**
     * Get the filtered identifiers.
     *
     * @return Collection
     */
    abstract protected function getFilteredIds(): ?Collection;

    /**
     * Get the filtered attribute.
     *
     * @return string
     */
    abstract protected function getFilteredAttribute(): string;

    /**
     * Get the filtered relation.
     *
     * @return string
     */
    abstract protected function getFilteredRelation(): string;
}
