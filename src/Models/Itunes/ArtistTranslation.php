<?php

namespace Appwapp\EPF\Models\Itunes;

use Appwapp\EPF\Models\EPFModel;
use Appwapp\EPF\Traits\HasCompositePrimaryKey;

class ArtistTranslation extends EPFModel
{
    use HasCompositePrimaryKey;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'artist_translation';

    /**
     * The primary key associated with the table.
     *
     * @var array
     */
    protected $primaryKey = [
        'artist_id',
        'language_code',
        'is_pronunciation',
        'translation_type_id'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'export_date',
        'artist_id',
        'language_code',
        'is_pronunciation',
        'translation',
        'translation_type_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_pronunciation' => 'boolean',
    ];
}
