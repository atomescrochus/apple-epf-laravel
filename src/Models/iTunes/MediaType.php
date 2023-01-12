<?php

namespace Appwapp\EPF\Models\iTunes;

use Appwapp\EPF\Traits\ExportDate;
use Illuminate\Database\Eloquent\Model;

class MediaType extends Model
{
    use ExportDate;

    public $timestamps = false;
    protected $connection = 'apple-epf';
    protected $table = 'media_type';
    protected $primaryKey = "media_type_id";
    protected $fillable = ['export_date', 'mediatype_id', 'name'];
}
