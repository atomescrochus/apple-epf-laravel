<?php

namespace Appwapp\EPF\Models\Itunes;

class ArtistCollection extends ItunesModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'artist_collection';

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
        'collection_id',
        'is_primary_artist',
        'role_id'
    ];
}
