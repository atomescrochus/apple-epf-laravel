<?php

namespace Appwapp\EPF\Models\Itunes;

use Appwapp\EPF\Models\EPFModel;
use Appwapp\EPF\Traits\HasCompositePrimaryKey;

class ArtistVideo extends EPFModel
{
    use HasCompositePrimaryKey;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'artist_video';

    /**
     * The primary key associated with the table.
     *
     * @var array
     */
    protected $primaryKey = [
        'artist_id',
        'video_id'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'export_date',
        'artist_id',
        'video_id',
        'is_primary_artist',
        'role_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_primary_artist' => 'boolean',
    ];
}
