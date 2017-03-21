<?php

namespace Atomescrochus\EPF\Models\iTunes;

use Illuminate\Database\Eloquent\Model;

class AlbumPopularityPerGenre extends Model
{
    public $timestamps = false;
    
    protected $connection = 'apple-epf';
    protected $table = 'album_popularity_per_genre';
    protected $primaryKey = "storefront_id";
    protected $fillable = ['export_date', 'storefront_id', 'genre_id', 'album_id', 'album_rank'];
}
