<?php

namespace Atomescrochus\EPF\Models\iTunes;

use Illuminate\Database\Eloquent\Model;

class CollectionTranslation extends Model
{

    protected $connection = 'apple-epf';
    protected $table = 'song_translation';
    protected $primaryKey = "song_id";

    protected $casts = [
        //
    ];

    public function song()
    {
        return $this->belongsTo(\Atomescrochus\EPF\Models\Song::class, 'song_id');
    }
}
