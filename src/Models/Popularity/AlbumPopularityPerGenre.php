<?php

namespace Appwapp\EPF\Models\Popularity;

use Appwapp\EPF\Models\EPFModel;
use Appwapp\EPF\Traits\HasCompositePrimaryKey;

class AlbumPopularityPerGenre extends EPFModel
{
    use HasCompositePrimaryKey;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'album_popularity_per_genre';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = [
        'storefront_id',
        'genre_id',
        'album_id'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'export_date',
        'storefront_id',
        'genre_id',
        'album_id',
        'album_rank'
    ];
}
