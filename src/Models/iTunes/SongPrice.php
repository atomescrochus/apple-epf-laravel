<?php

namespace Appwapp\EPF\Models\iTunes;

use Appwapp\EPF\Traits\ExportDate;
use Illuminate\Database\Eloquent\Model;

class SongPrice extends Model
{
    use ExportDate;

    public $timestamps = false;
    protected $connection = 'apple-epf';
    protected $table = 'song_price';
    protected $primaryKey = "song_id";
    protected $fillable = ['export_date', 'song_id', 'retail_price', 'storefront_id', 'currency_code', 'availability_date', 'hq_price'];
}
