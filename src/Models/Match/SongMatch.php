<?php

namespace Appwapp\EPF\Models\Match;

use Appwapp\EPF\Models\EPFModel;

class SongMatch extends EPFModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'song_match';

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
        'isrc',
        'amg_track_id'
    ];
}
