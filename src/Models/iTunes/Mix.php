<?php

namespace Appwapp\EPF\Models\Itunes;

class Mix extends ItunesModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'mix';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'mix_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'export_date',
        'mix_id',
        'mix_collection_id',
        'name',
        'description',
        'rank',
        'view_url'
    ];
}
