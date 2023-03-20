<?php

namespace Appwapp\EPF\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;

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

    /**
     * When the model is booted, add a creating 
     * event to filter the rows created.
     *
     * @return void
     */
    protected static function booted ()
    {
        // Call parent boot method
        parent::booted();

        // Add creating event
        static::creating(function (Model $model) {
            $cacheKey = "filtered:{$model->getFilteredRelation()}.{$model->getFilteredAttribute()}";

            // Check if the filtered identifiers are cached
            if (Cache::has($cacheKey)) {
                $filteredIds = Cache::get($cacheKey);
            } else {
                // Get the filtered identifiers
                $filteredIds = $model->getFilteredIds();

                // Store the filtered identifiers for 24 hours
                Cache::put($cacheKey, $filteredIds, 86400);
            }

            Log::debug(print_r($filteredIds->toArray(), true));

            if ($filteredIds->contains($model->getAttribute($model->getFilteredAttribute()))) {
                // The model is filtered, so we don't want to create it
                return false;
            }
        });
    }
}
