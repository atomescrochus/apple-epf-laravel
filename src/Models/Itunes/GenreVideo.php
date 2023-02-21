<?php

namespace Appwapp\EPF\Models\Itunes;

use Appwapp\EPF\Models\EPFModel;
use Appwapp\EPF\Traits\HasCompositePrimaryKey;

class GenreVideo extends EPFModel
{
    use HasCompositePrimaryKey;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'genre_video';

    /**
     * The primary key associated with the table.
     *
     * @var array
     */
    protected $primaryKey = [
        'genre_id',
        'video_id'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'export_date',
        'genre_id',
        'video_id',
        'is_primary_genre'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_primary_genre' => 'boolean',
    ];
}
