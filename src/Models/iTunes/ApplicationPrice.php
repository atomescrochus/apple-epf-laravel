<?php

namespace Appwapp\EPF\Models\Itunes;

class ApplicationPrice extends ITunesModel
{
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
    protected $primaryKey = 'storefront_id';
    
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
