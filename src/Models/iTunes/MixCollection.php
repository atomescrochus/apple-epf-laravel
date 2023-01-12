<?php

namespace Appwapp\EPF\Models\iTunes;

use Appwapp\EPF\Traits\ExportDate;
use Illuminate\Database\Eloquent\Model;

class MixCollection extends Model
{
    use ExportDate;

    public $timestamps = false;
    protected $connection = 'apple-epf';
    protected $table = 'mix_collection';
    protected $primaryKey = "mix_collection_id";
    protected $fillable = ['export_date', 'mix_collection_id', 'title', 'storefront_id', 'parental_advisory_id', 'mix_category_name', 'mix_type_id', 'itunes_release_date', 'view_url', 'artwork_url_large', 'artwork_url_small'];
}
