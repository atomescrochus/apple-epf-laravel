<?php

namespace Appwapp\EPF\Models\Itunes;

class ArtistMatch extends ItunesModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'artist_match';

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
        'amg_artist_id',
        'amg_video_artist_id'
    ];
}
