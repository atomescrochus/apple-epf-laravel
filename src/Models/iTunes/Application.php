<?php

namespace Appwapp\EPF\Models\Itunes;

use Appwapp\EPF\Models\EPFModel;

class Application extends EPFModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'application';

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
        'title',
        'recommended_age',
        'artist_name',
        'seller_name',
        'company_url',
        'support_url',
        'view_url',
        'artwork_url_large',
        'artwork_url_small',
        'itunes_release_date',
        'copyright',
        'description',
        'version',
        'itunes_version',
        'download_size'
    ];
}
