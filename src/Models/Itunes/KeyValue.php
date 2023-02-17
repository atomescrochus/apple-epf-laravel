<?php

namespace Appwapp\EPF\Models\Itunes;

use Appwapp\EPF\Models\EPFModel;

class KeyValue extends EPFModel
{
    /**
     * Key constants.
     *
     * @var string
     */
    public const
        KEY_EXPORT_VERSION        = 'exportVersion',
        KEY_LAST_FULL_EXPORT_DATE = 'lastFullExportDate';

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
    protected $primaryKey = 'key_';

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
