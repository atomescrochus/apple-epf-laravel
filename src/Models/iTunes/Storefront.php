<?php

namespace Appwapp\EPF\Models\iTunes;

use Appwapp\EPF\Traits\ExportDate;
use Illuminate\Database\Eloquent\Model;

class Storefront extends Model
{
    use ExportDate;

    public $timestamps = false;
    protected $connection = 'apple-epf';
    protected $table = 'storefront';
    protected $primaryKey = "storefront_id";
    protected $fillable = ['export_date', 'storefront_id', 'country_code', 'name'];
}
