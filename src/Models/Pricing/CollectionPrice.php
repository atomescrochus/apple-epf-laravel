<?php

namespace Appwapp\EPF\Models\Itunes;

use Appwapp\EPF\Models\EPFModel;

class CollectionPrice extends EPFModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'collection_price';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'collection_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'export_date',
        'collection_id',
        'retail_price',
        'storefront_id',
        'currency_code',
        'availability_date',
        'hq_price'
    ];
}
