<?php

namespace Appwapp\EPF\Models\Itunes;

class CollectionSong extends ItunesModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'collection_song';

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
        'song_id',
        'is_primary_collection',
        'track_number',
        'volume_number',
        'preorder_only'
    ];
}
