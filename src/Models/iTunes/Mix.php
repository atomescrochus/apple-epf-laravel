<?php

namespace Appwapp\EPF\Models\iTunes;

use Appwapp\EPF\Traits\ExportDate;
use Illuminate\Database\Eloquent\Model;

class Mix extends Model
{
    use ExportDate;

    public $timestamps = false;
    protected $connection = 'apple-epf';
    protected $table = 'mix';
    protected $primaryKey = "mix_id";
    protected $fillable = ['export_date', 'mix_id', 'mix_collection_id', 'name', 'description', 'rank', 'view_url'];
}
