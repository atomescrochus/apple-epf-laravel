<?php

namespace Atomescrochus\EPF\Models\iTunes;

use Atomescrochus\EPF\Traits\ExportDate;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use ExportDate;

    public $timestamps = false;
    protected $connection = 'apple-epf';
    protected $table = 'collection';
    protected $primaryKey = "collection_id";
    protected $fillable = ['export_date', 'collection_id', 'name', 'title_version', 'search_terms', 'parental_advisory_id', 'artist_display_name', 'view_url', 'artwork_url', 'original_release_date', 'itunes_release_date', 'label_studio', 'content_provider', 'copyright', 'pline', 'media_type_id', 'is_compilation', 'collection_type_id'];

    protected $casts = [
        'is_compilation' => 'boolean',
    ];

    // relationships

    public function artists()
    {
        return $this->belongsToMany(\Atomescrochus\EPF\Models\Artist::class, 'artist_collection', 'artist_id', 'collection_id');
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'genre_collection', 'collection_id', 'genre_id');
    }

    public function mixes()
    {
        return $this->belongsToMany(\Atomescrochus\EPF\Models\Mix::class, 'mix_collection', 'collection_id', 'mix_id');
    }

    public function songs()
    {
        return $this->belongsToMany(\Atomescrochus\EPF\Models\Song::class, 'collection_song', 'collection_id', 'song_id');
    }

    public function translations()
    {
        return $this->hasMany(CollectionTranslation::class, 'collection_id');
    }

    public function type()
    {
        return $this->belongsto(CollectionType::class, 'collection_type_id');
    }

    public function videos()
    {
        return $this->belongsToMany(\Atomescrochus\EPF\Models\Video::class, 'collection_video', 'collection_id', 'video_id');
    }
}
