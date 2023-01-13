<?php

namespace Appwapp\EPF\Models\Itunes;

class SongPrice extends ItunesModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'song_price';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'song_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'export_date',
        'song_id',
        'retail_price',
        'storefront_id',
        'currency_code',
        'availability_date',
        'hq_price'
    ];
}
