<?php

namespace Atomescrochus\EPF\Models\iTunes;

use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{

    protected $connection = 'apple-epf';
    protected $table = 'artist';
    protected $primaryKey = "artist_id";

    protected $casts = [
        'is_actual_artist' => 'boolean',
    ];

    public function type()
    {
        return $this->belongsTo(\Atomescrochus\EPF\Models\ArtistType::class, 'artist_type_id', 'artist_type_id');
    }

    public function applications()
    {
        return $this->belongsToMany(\Atomescrochus\EPF\Models\Application::class, 'artist_application', 'artist_id', 'application_id');
    }

    public function videos()
    {
        return $this->belongsToMany(\Atomescrochus\EPF\Models\Video::class, 'artist_video', 'artist_id', 'video_id');
    }

    public function songs()
    {
        return $this->belongsToMany(\Atomescrochus\EPF\Models\Song::class, 'artist_song', 'artist_id', 'song_id');
    }

    public function translations()
    {
        return $this->hasMany(ArtistTranslation::class, 'artist_id');
    }

    public function collections()
    {
        return $this->belongsToMany(\Atomescrochus\EPF\Models\Collections::class, 'artist_collection', 'collection_id', 'artist_id');
    }
}
