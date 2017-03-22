<?php

namespace Atomescrochus\EPF\Models\iTunes;

use Atomescrochus\EPF\Traits\ExportDate;
use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    use ExportDate;

    public $timestamps = false;
    protected $connection = 'apple-epf';
    protected $table = 'artist';
    protected $primaryKey = "artist_id";
    protected $fillable = ['export_date', 'artist_id', 'name', 'search_terms', 'is_actual_artist', 'view_url', 'artist_type_id'];

    protected $casts = [
        'is_actual_artist' => 'boolean',
    ];
}
