<?php

namespace Appwapp\EPF\Models\Itunes;

use Appwapp\EPF\Models\EPFModel;

class MediaType extends EPFModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'media_type';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'media_type_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'export_date',
        'mediatype_id',
        'name'
    ];
}
