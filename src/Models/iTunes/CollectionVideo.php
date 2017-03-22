<?php

namespace Atomescrochus\EPF\Models\iTunes;

use Atomescrochus\EPF\Traits\ExportDate;
use Illuminate\Database\Eloquent\Model;

class CollectionVideo extends Model
{
    use ExportDate;

    public $timestamps = false;
    protected $connection = 'apple-epf';
    protected $table = 'collection_video';
    protected $primaryKey = "collection_id";
    protected $fillable = ['export_date', 'collection_type_id', 'video_id', 'track_number', 'volume_number', 'preorder_only'];
}
