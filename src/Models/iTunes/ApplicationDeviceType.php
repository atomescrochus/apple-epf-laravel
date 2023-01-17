<?php

namespace Appwapp\EPF\Models\Itunes;

use Appwapp\EPF\Models\EPFModel;

class ApplicationDeviceType extends EPFModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'application_device_type';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'application_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'export_date',
        'application_id',
        'device_type_id'
    ];
}
