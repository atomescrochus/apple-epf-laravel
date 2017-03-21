<?php

namespace Atomescrochus\EPF\Models\iTunes;

use Illuminate\Database\Eloquent\Model;

class ArtistSong extends Model
{
    public $timestamps = false;
    
    protected $connection = 'apple-epf';
    protected $table = 'artist_song';
    protected $primaryKey = "artist_id";
    protected $fillable = ['export_date', 'artist_id', 'song_id'];
}
