<?php

namespace Atomescrochus\EPF\Models\iTunes;

use Atomescrochus\EPF\Traits\ExportDate;
use Illuminate\Database\Eloquent\Model;

class VideoPrice extends Model
{
    use ExportDate;

    public $timestamps = false;
    protected $connection = 'apple-epf';
    protected $table = 'video_price';
    protected $primaryKey = "video";
    protected $fillable = ['export_date', 'video', 'retail_price', 'storefront_id', 'currency_code', 'availability_date', 'sd_price', 'hq_price', 'lc_rental_price', 'sd_rental_price', 'hd_rental_price'];
}
