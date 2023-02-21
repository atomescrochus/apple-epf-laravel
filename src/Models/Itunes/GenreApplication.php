<?php

namespace Appwapp\EPF\Models\Itunes;

use Appwapp\EPF\Models\EPFModel;
use Appwapp\EPF\Traits\HasCompositePrimaryKey;

class GenreApplication extends EPFModel
{
    use HasCompositePrimaryKey;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'genre_application';

    /**
     * The primary key associated with the table.
     *
     * @var array
     */
    protected $primaryKey = [
        'genre_id',
        'application_id'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'export_date',
        'genre_id',
        'application_id',
        'is_primary'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_primary' => 'boolean',
    ];
}
