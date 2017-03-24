<?php

namespace Atomescrochus\EPF\Models\iTunes;

use Atomescrochus\EPF\Traits\ExportDate;
use Illuminate\Database\Eloquent\Model;

class ApplicationDeviceType extends Model
{
    use ExportDate;
    
    public $timestamps = false;
    
    protected $connection = 'apple-epf';
    protected $table = 'application_device_type';
    protected $primaryKey = "application_id";
    protected $fillable = ['export_date', 'application_id', 'device_type_id'];
}
