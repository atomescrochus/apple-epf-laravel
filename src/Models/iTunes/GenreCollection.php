<?php

namespace Appwapp\EPF\Models\Itunes;

use Appwapp\EPF\Models\EPFModel;

class GenreCollection extends EPFModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'genre_collection';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'genre_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'export_date',
        'genre_id',
        'collection_id',
        'is_primary_collection'
    ];
}
