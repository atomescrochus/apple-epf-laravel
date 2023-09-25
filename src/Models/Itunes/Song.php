<?php

namespace Appwapp\EPF\Models\Itunes;

use Appwapp\EPF\Models\EPFModel;
use Appwapp\EPF\Traits\HasSearchTerms;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

class Song extends EPFModel
{
    use HasSearchTerms;

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

    /**
     * Gets the Song's artist_song
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function artistSong(): BelongsToMany
    {
        return $this->belongsToMany(ArtistSong::class, 'artist_song', 'song_id', 'artist_id');
    }

    /**
     * Get the filtered identifiers.
     *
     * @return Collection
     */
    protected function getFilteredIds(): ?Collection
    {
        return $this->artistSong()->get()->pluck('song_id');
    }

    /**
     * Get the filtered attribute.
     *
     * @return string
     */
    protected function getFilteredAttribute(): string
    {
        return 'song_id';
    }

    /**
     * Get the filtered relation.
     *
     * @return string
     */
    protected function getFilteredRelation(): string
    {
        return 'artist_song';
    }
}
