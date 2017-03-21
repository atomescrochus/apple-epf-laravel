<?php

namespace Atomescrochus\EPF\Models\iTunes;

use Illuminate\Database\Eloquent\Model;

class CollectionPrice extends Model
{
    public $timestamps = false;
    
    protected $connection = 'apple-epf';
    protected $table = 'collection_price';
    protected $primaryKey = "collection_id";
    protected $fillable = ['export_date', 'collection_id', 'retail_price', 'storefront_id', 'currency_code', 'availability_date', 'hq_price'];
}
