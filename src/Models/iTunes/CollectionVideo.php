<?php

namespace Appwapp\EPF\Models\Itunes;

class CollectionVideo extends ItunesModel
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'collection_video';

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
        'collection_type_id',
        'video_id',
        'track_number',
        'volume_number',
        'preorder_only'
    ];
}
