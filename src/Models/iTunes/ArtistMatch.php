<?php

namespace Appwapp\EPF\Models\iTunes;

use Appwapp\EPF\Traits\ExportDate;
use Illuminate\Database\Eloquent\Model;

class ArtistMatch extends Model
{
    use ExportDate;
    
    public $timestamps = false;
    
    protected $connection = 'apple-epf';
    protected $table = 'artist_match';
    protected $primaryKey = "artist_id";
    protected $fillable = ['export_date', 'artist_id', 'amg_artist_id', 'amg_video_artist_id'];
}
