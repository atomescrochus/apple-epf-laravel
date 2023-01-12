<?php

namespace Appwapp\EPF\Models\iTunes;

use Appwapp\EPF\Models\iTunes\Collection;
use Appwapp\EPF\Models\iTunes\ParentalAdvisory;
use Appwapp\EPF\Traits\ExportDate;
use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    use ExportDate;

    public $timestamps = false;
    protected $connection = 'apple-epf';
    protected $table = 'song';
    protected $primaryKey = "song_id";
    protected $fillable = ['export_date', 'song_id', 'name', 'title_version', 'search_terms', 'parental_advisory_id', 'artist_display_name', 'collection_display_name', 'view_url', 'original_release_date', 'itunes_release_date', 'track_length', 'copyright', 'p_line', 'preview_url ', 'preview_length'];

    public function collections()
    {
        return $this->belongsToMany(Collection::class, 'collection_song', 'song_id', 'collection_id');
    }
}
