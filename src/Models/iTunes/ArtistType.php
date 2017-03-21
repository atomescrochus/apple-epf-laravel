<?php

namespace Atomescrochus\EPF\Models\iTunes;

use Atomescrochus\EPF\Traits\ExportDate;
use Illuminate\Database\Eloquent\Model;

class ArtistType extends Model
{
    use ExportDate;

    public $timestamps = false;
    protected $connection = 'apple-epf';
    protected $table = 'artist_type';
    protected $primaryKey = "artist_type_id";
    protected $fillable = ['export_date', 'artist_id', 'video_id', 'is_primary_artist', 'role_id'];

    // relationships

    public function artists()
    {
        return $this->belongsTo(\Atomescrochus\EPF\Models\Artist::class, 'artist_type_id', 'artist_type_id');
    }

    public function primaryMedia()
    {
        return $this->belongsTo(\Atomescrochus\EPF\Models\MediaType::class, 'primary_media_type_id', 'media_type_id');
    }
}
