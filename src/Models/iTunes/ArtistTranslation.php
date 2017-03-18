<?php

namespace Atomescrochus\EPF\Models\iTunes;

use Illuminate\Database\Eloquent\Model;

class ArtistTranslation extends Model
{

    protected $connection = 'apple-epf';
    protected $table = 'artist_translation';
    protected $primaryKey = "artist_id";

    protected $casts = [
        //
    ];

    public function artist()
    {
        return $this->belongsTo(\Atomescrochus\EPF\Models\Artist::class, 'artist_id');
    }
}
