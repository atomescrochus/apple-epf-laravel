<?php

namespace Appwapp\EPF\Models\Itunes;

class Artist extends ItunesModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'artist';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'artist_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'export_date',
        'artist_id',
        'name',
        'search_terms',
        'is_actual_artist',
        'view_url',
        'artist_type_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_actual_artist' => 'boolean',
    ];
}
