<?php

namespace Appwapp\EPF\Models\Match;

use Appwapp\EPF\Models\EPFModel;

class ArtistMatch extends EPFModel
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
