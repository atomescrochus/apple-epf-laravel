<?php

namespace Appwapp\EPF\Models\iTunes;

use Appwapp\EPF\Traits\ExportDate;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use ExportDate;

    public $timestamps = false;
    protected $connection = 'apple-epf';
    protected $table = 'video';
    protected $primaryKey = "video_id";
    protected $fillable = ['export_date', 'video_id', 'name','title_version', 'search_terms', 'parental_advisory_id', 'artist_display_name', 'collection_display_name', 'media_type', 'view_url', 'artwork_url', 'original_release_date','itunes_release_date', 'studio_name', 'network_name', 'content_provider', 'track_length', 'copyright', 'p_line', 'short_description', 'long_description', 'episode_production_number'];
}
