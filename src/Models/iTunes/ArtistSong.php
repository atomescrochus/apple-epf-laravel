<?php

namespace Appwapp\EPF\Models\Itunes;

use Appwapp\EPF\Models\EPFModel;

class ArtistSong extends EPFModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'artist_song';

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
        'song_id'
    ];
}
