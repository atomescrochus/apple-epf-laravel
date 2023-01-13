<?php

namespace Appwapp\EPF\Models\Itunes;

use Appwapp\EPF\Traits\ExportDate;
use Illuminate\Database\Eloquent\Model;

class Storefront extends ItunesModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'storefront';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'storefront_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'export_date',
        'storefront_id',
        'country_code',
        'name'
    ];
}
