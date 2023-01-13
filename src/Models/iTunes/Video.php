<?php

namespace Appwapp\EPF\Models\Itunes;

class Video extends ItunesModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'video';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'video_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'export_date',
        'video_id',
        'name',
        'title_version',
        'search_terms',
        'parental_advisory_id',
        'artist_display_name',
        'collection_display_name',
        'media_type',
        'view_url',
        'artwork_url',
        'original_release_date',
        'itunes_release_date',
        'studio_name',
        'network_name',
        'content_provider',
        'track_length',
        'copyright',
        'p_line',
        'short_description',
        'long_description',
        'episode_production_number'
    ];
}
