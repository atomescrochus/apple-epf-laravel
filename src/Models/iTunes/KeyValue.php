<?php

namespace Appwapp\EPF\Models\Itunes;

class KeyValue extends ItunesModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'key_value';

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
        'key_',
        'value_'
    ];
}
