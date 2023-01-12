<?php

namespace Appwapp\EPF\Models\iTunes;

use Appwapp\EPF\Traits\ExportDate;
use Illuminate\Database\Eloquent\Model;

class CollectionType extends Model
{
    use ExportDate;

    public $timestamps = false;
    protected $connection = 'apple-epf';
    protected $table = 'collection_type';
    protected $primaryKey = "collection_type_id";
    protected $fillable = ['export_date', 'collection_type_id', 'name'];
}
