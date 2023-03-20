<?php

namespace Appwapp\EPF\Models\Itunes;

use Appwapp\EPF\Models\EPFModel;
use Appwapp\EPF\Traits\Filterable;
use Appwapp\EPF\Traits\HasSearchTerms;
use Illuminate\Support\Collection;

class Artist extends EPFModel
{
    use Filterable, HasSearchTerms;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'artist';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'artist_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'export_date',
        'artist_id',
        'name',
        'search_terms',
        'is_actual_artist',
        'view_url',
        'artist_type_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_actual_artist' => 'boolean',
    ];

    /**
     * Get the filtered identifiers.
     *
     * @return Collection
     */
    protected function getFilteredIds(): ?Collection
    {
        // Check if Artist is configured to be filtered
        $filteredBy = config('apple-epf.filter_by');
        if (!isset($filteredBy[self::class])) {
            return null;
        }
    
        // Get the filtered model
        $model = $filteredBy[self::class]['model'];

        // Returns the filtered collection
        return $model::get()->pluck($filteredBy[self::class]['attribute']);
    }

    /**
     * Get the filtered attribute.
     *
     * @return string
     */
    protected function getFilteredAttribute(): string
    {
        return 'artist_id';
    }

    /**
     * Get the filtered relation.
     *
     * @return string
     */
    protected function getFilteredRelation(): string
    {
        return 'artist';
    }
}
