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
}
