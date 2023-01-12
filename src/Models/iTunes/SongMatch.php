<?php

namespace Appwapp\EPF\Models\iTunes;

use Illuminate\Database\Eloquent\Model;

class SongMatch extends Model
{
    use ExportDate;

    public $timestamps = false;
    protected $connection = 'apple-epf';
    protected $table = 'song_match';
    protected $primaryKey = "song_id";
    protected $fillable = ['export_date', 'song_id', 'isrc', 'amg_track_id'];
}
