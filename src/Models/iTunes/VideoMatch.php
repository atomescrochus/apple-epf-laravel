<?php

namespace Appwapp\EPF\Models\iTunes;

use Appwapp\EPF\Traits\ExportDate;
use Illuminate\Database\Eloquent\Model;

class VideoMatch extends Model
{
    use ExportDate;
    
    public $timestamps = false;
    
    protected $connection = 'apple-epf';
    protected $table = 'video_match';
    protected $primaryKey = "video_id";
    protected $fillable = ['export_date', 'video_id', 'upc', 'isrc', 'amg_video_id', 'isan'];
}
