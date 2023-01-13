<?php

namespace Appwapp\EPF\Models\Itunes;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Song extends ItunesModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'song';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'song_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'export_date',
        'song_id',
        'name',
        'title_version',
        'search_terms',
        'parental_advisory_id',
        'artist_display_name',
        'collection_display_name',
        'view_url',
        'original_release_date',
        'itunes_release_date',
        'track_length',
        'copyright',
        'p_line',
        'preview_url ',
        'preview_length'
    ];

    /**
     * Gets the Song's collections
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function collections(): BelongsToMany
    {
        return $this->belongsToMany(Collection::class, 'collection_song', 'song_id', 'collection_id');
    }
}
