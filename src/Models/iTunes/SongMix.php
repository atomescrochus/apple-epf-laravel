<?php

namespace Appwapp\EPF\Models\Itunes;

use Appwapp\EPF\Traits\ExportDate;
use Illuminate\Database\Eloquent\Model;

class SongMix extends ItunesModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'song_mix';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'song_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'export_date',
        'song_id',
        'mix_id'
    ];
}
