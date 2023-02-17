<?php

namespace Appwapp\EPF\Models\Itunes;

use Appwapp\EPF\Models\EPFModel;

use Appwapp\EPF\Traits\HasSearchTerms;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Collection extends EPFModel
{
    use HasSearchTerms;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'collection';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'collection_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'export_date',
        'collection_id',
        'name',
        'title_version',
        'search_terms',
        'parental_advisory_id',
        'artist_display_name',
        'view_url',
        'artwork_url',
        'original_release_date',
        'itunes_release_date',
        'label_studio',
        'content_provider',
        'copyright',
        'pline',
        'media_type_id',
        'is_compilation',
        'collection_type_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_compilation' => 'boolean',
    ];

    /**
     * Get the Collection's genres
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class, 'genre_collection', 'collection_id', 'genre_id');
    }

    /**
     * Get the primary_genre attribute
     * 
     * @return Genre|null
     */
    public function getPrimaryGenreAttribute(): ?Genre
    {
        return $this->genres()->where('is_primary', 1)->first();
    }
}
