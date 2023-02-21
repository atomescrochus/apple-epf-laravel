<?php

namespace Appwapp\EPF\Models\Match;

use Appwapp\EPF\Models\EPFModel;

class CollectionMatch extends EPFModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'collection_match';

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
        'upc',
        'amg_album_id'
    ];
}
