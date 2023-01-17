<?php

namespace Appwapp\EPF\Models\Itunes;

use Appwapp\EPF\Models\EPFModel;

class TranslationType extends EPFModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'translation_type';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'translation_type_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'export_date',
        'translation_type_id',
        'name'
    ];
}
