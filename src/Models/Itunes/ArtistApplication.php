<?php

namespace Appwapp\EPF\Models\Itunes;

use Appwapp\EPF\Models\EPFModel;
use Appwapp\EPF\Traits\HasCompositePrimaryKey;

class ArtistApplication extends EPFModel
{
    use HasCompositePrimaryKey;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'artist_application';
    
    /**
     * The primary key associated with the table.
     *
     * @var array
     */
    protected $primaryKey = [
        'artist_id',
        'application_id'
    ];

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
