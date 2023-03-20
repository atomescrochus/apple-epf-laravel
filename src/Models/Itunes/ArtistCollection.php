<?php

namespace Appwapp\EPF\Models\Itunes;

use Appwapp\EPF\Models\EPFModel;
use Appwapp\EPF\Traits\Filterable;
use Appwapp\EPF\Traits\HasCompositePrimaryKey;
use Illuminate\Support\Collection;

class ArtistCollection extends EPFModel
{
    use Filterable, HasCompositePrimaryKey;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'artist_collection';

    /**
     * The primary key associated with the table.
     *
     * @var array
     */
    protected $primaryKey = [
        'artist_id',
        'collection_id'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'export_date',
        'artist_id',
        'collection_id',
        'is_primary_artist',
        'role_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_primary_artist' => 'boolean',
    ];

    /**
     * Get the artist that owns the artist collection.
     */
    public function artist ()
    {
        return $this->belongsTo(Artist::class, 'artist_id', 'artist_id');
    }

    /**
     * Get the filtered identifiers.
     *
     * @return Collection
     */
    protected function getFilteredIds(): ?Collection
    {
        return $this->artist()->get()->pluck('artist_id');
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
