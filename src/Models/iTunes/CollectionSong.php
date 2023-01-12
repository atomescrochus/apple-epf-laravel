<?php

namespace Appwapp\EPF\Models\iTunes;

use Appwapp\EPF\Traits\ExportDate;
use Illuminate\Database\Eloquent\Model;

class CollectionSong extends Model
{
    use ExportDate;
    
    public $timestamps = false;
    
    protected $connection = 'apple-epf';
    protected $table = 'collection_song';
    protected $primaryKey = "collection_id";
    protected $fillable = ['export_date', 'collection_id', 'song_id', 'is_primary_collection', 'track_number', 'volume_number', 'preorder_only'];
}
