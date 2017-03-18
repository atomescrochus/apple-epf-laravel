<?php

namespace Atomescrochus\EPF\Models\iTunes;

use Atomescrochus\EPF\Traits\ExportDate;
use Illuminate\Database\Eloquent\Model;

class CollectionTranslation extends Model
{

    use ExportDate;

    protected $connection = 'apple-epf';
    protected $table = 'song_translation';
    protected $primaryKey = "song_id";

    protected $casts = [
        'is_pronunciation' => 'boolean',
    ];

    // relationships
    
    public function song()
    {
        return $this->belongsTo(\Atomescrochus\EPF\Models\Song::class, 'song_id');
    }
}
