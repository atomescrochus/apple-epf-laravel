<?php

namespace Atomescrochus\EPF\Models\iTunes;

use Illuminate\Database\Eloquent\Model;

class ArtistCollection extends Model
{
    public $timestamps = false;
    
    protected $connection = 'apple-epf';
    protected $table = 'artist_collection';
    protected $primaryKey = "artist_id";
    protected $fillable = ['export_date', 'artist_id', 'collection_id', 'is_primary_artist', 'role_id'];
}
