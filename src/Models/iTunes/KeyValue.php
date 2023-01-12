<?php

namespace Appwapp\EPF\Models\iTunes;

use Appwapp\EPF\Traits\ExportDate;
use Illuminate\Database\Eloquent\Model;

class KeyValue extends Model
{
    use ExportDate;

    public $timestamps = false;
    protected $connection = 'apple-epf';
    protected $table = 'key_value';
    protected $primaryKey = "genre_id";
    protected $fillable = ['export_date', 'key_', 'value_'];
}
