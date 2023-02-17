<?php

namespace Appwapp\EPF\Models\Itunes;

use Appwapp\EPF\Models\EPFModel;

class MixCollection extends EPFModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mix_collection';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'mix_collection_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'export_date',
        'mix_collection_id',
        'title',
        'storefront_id',
        'parental_advisory_id',
        'mix_category_name',
        'mix_type_id',
        'itunes_release_date',
        'view_url',
        'artwork_url_large',
        'artwork_url_small',
    ];
}
