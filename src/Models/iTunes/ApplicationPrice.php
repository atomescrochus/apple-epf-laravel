<?php

namespace Appwapp\EPF\Models\iTunes;

use Appwapp\EPF\Traits\ExportDate;
use Illuminate\Database\Eloquent\Model;

class ApplicationPrice extends Model
{
    use ExportDate;
    
    public $timestamps = false;
    
    protected $connection = 'apple-epf';
    protected $table = 'application_price';
    protected $primaryKey = "storefront_id";
    protected $fillable = ['export_date', 'application_id', 'retail_price', 'currency_code', 'storefront_id'];
}
