<?php

namespace Atomescrochus\EPF\Models\iTunes;

use Atomescrochus\EPF\Traits\ExportDate;
use Illuminate\Database\Eloquent\Model;

class CollectionMatch extends Model
{
    use ExportDate;
    
    public $timestamps = false;
    
    protected $connection = 'apple-epf';
    protected $table = 'collection_match';
    protected $primaryKey = "collection_id";
    protected $fillable = ['export_date', 'collection_id', 'upc', 'grid', 'amg_album_id'];
}
