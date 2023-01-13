<?php

namespace Appwapp\EPF\Models\Itunes;

use Appwapp\EPF\Traits\ExportDate;
use Illuminate\Database\Eloquent\Model;

class CollectionTranslation extends ItunesModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'collection_translation';

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
        'language_code',
        'is_pronunciation',
        'translation',
        'translation_type_id'
    ];
}
