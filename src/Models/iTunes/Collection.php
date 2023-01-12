<?php

namespace Appwapp\EPF\Models\iTunes;

use Appwapp\EPF\Models\iTunes\Genre;
use Appwapp\EPF\Traits\ExportDate;
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

    public function genres()
    {
        return $this->belongsToMany(Genre::class, 'genre_collection', 'collection_id', 'genre_id');
    }

    public function getPrimaryGenreAttribute()
    {
        return $this->genres()->where('is_primary', 1)->first();
    }
}
