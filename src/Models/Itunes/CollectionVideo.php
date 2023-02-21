<?php

namespace Appwapp\EPF\Models\Itunes;

use Appwapp\EPF\Models\EPFModel;
use Appwapp\EPF\Traits\HasCompositePrimaryKey;

class CollectionVideo extends EPFModel
{
    use HasCompositePrimaryKey;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'collection_video';

    /**
     * The primary key associated with the table.
     *
     * @var array
     */
    protected $primaryKey = [
        'collection_id',
        'video_id'
    ];

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
