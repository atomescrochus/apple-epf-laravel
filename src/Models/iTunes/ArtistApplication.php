<?php

namespace Appwapp\EPF\Models\Itunes;

class ArtistApplication extends ItunesModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'artist_application';
    
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'artist_id';

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $fillable = [
        'export_date',
        'artist_id',
        'application_id'
    ];
}
