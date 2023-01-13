<?php

namespace Appwapp\EPF\Models\Itunes;

class VideoPrice extends ItunesModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'video_price';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'video';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'export_date',
        'video',
        'retail_price',
        'storefront_id',
        'currency_code',
        'availability_date',
        'sd_price',
        'hq_price',
        'lc_rental_price',
        'sd_rental_price',
        'hd_rental_price'
    ];
}
