<?php

namespace Atomescrochus\EPF\Models\iTunes;

use Atomescrochus\EPF\Traits\ExportDate;
use Illuminate\Database\Eloquent\Model;

class DeviceType extends Model
{
    use ExportDate;

    public $timestamps = false;
    protected $connection = 'apple-epf';
    protected $table = 'device_type';
    protected $primaryKey = "device_type_id";
    protected $fillable = ['export_date', 'device_type_id', 'name'];
}
