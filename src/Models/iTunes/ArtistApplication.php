<?php

namespace Atomescrochus\EPF\Models\iTunes;

use Illuminate\Database\Eloquent\Model;

class ArtistApplication extends Model
{
    public $timestamps = false;
    
    protected $connection = 'apple-epf';
    protected $table = 'artist_application';
    protected $primaryKey = "artist_id";
    protected $fillable = ['export_date', 'artist_id', 'application_id'];
}
