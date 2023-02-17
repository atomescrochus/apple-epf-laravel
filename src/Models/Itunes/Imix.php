<?php

namespace Appwapp\EPF\Models\Itunes;

use Appwapp\EPF\Models\EPFModel;

class Imix extends EPFModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'imix';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'imix_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'export_date',
        'imix_id',
        'title',
        'description',
        'storefront_id',
        'rating_average',
        'rating_count',
        'itunes_release_date',
        'imix_type_id',
        'view_url',
    ];
}
