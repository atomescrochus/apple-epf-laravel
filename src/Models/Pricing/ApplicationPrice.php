<?php

namespace Appwapp\EPF\Models\Pricing;

use Appwapp\EPF\Models\EPFModel;
use Appwapp\EPF\Traits\HasCompositePrimaryKey;

class ApplicationPrice extends EPFModel
{
    use HasCompositePrimaryKey;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'application_price';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = [
        'application_id',
        'storefront_id'
    ];
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'export_date',
        'application_id',
        'retail_price',
        'currency_code',
        'storefront_id'
    ];
}
