<?php

namespace Atomescrochus\EPF\Models\iTunes;

use Illuminate\Database\Eloquent\Model;

class DeviceType extends Model
{

    protected $connection = 'apple-epf';
    protected $table = 'device_type';
    protected $primaryKey = "device_type_id";

    protected $casts = [
        //
    ];

    public function applications()
    {
        return $this->belongsToMany(Application::class, 'application_device_type', 'device_type_id', 'application_id');
    }
}
