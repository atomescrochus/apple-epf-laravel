<?php

namespace Atomescrochus\EPF\Models\iTunes;

use Illuminate\Database\Eloquent\Model;

class ApplicationDeviceType extends Model
{
    public $timestamps = false;
    
    protected $connection = 'apple-epf';
    protected $table = 'application_device_type';
    protected $primaryKey = "application_id";
    protected $fillable = ['export_date', 'application_id', 'device_type_id'];
}
