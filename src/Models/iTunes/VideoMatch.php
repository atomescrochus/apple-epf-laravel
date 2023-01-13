<?php

namespace Appwapp\EPF\Models\Itunes;

class VideoMatch extends ItunesModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'video_match';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'video_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'export_date',
        'video_id',
        'upc',
        'isrc',
        'amg_video_id',
        'isan'
    ];
}
