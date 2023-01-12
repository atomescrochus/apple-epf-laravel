<?php

namespace Appwapp\EPF\Models\iTunes;

use Appwapp\EPF\Traits\ExportDate;
use Illuminate\Database\Eloquent\Model;

class ApplicationDetail extends Model
{
    use ExportDate;

    public $timestamps = false;
    protected $connection = 'apple-epf';
    protected $table = 'application_detail';
    protected $primaryKey = "application_id";
    protected $fillable = ['export_date', 'application_id', 'title', 'description', 'release_notes', 'company_url', 'suppport_url', 'screenshot_url_1', 'screenshot_url_2', 'screenshot_url_3', 'screenshot_url_4', 'screenshot_width_height_1', 'screenshot_width_height_2', 'screenshot_width_height_3', 'screenshot_width_height_4'];
}
