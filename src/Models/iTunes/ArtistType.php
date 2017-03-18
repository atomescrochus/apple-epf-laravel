<?php

namespace Atomescrochus\EPF\Models\iTunes;

use Illuminate\Database\Eloquent\Model;

class ArtistType extends Model
{

    protected $connection = 'apple-epf';
    protected $table = 'artist_type';
    protected $primaryKey = "artist_type_id";

    protected $casts = [
        //
    ];

    public function artists()
    {
        return $this->belongsTo(\Atomescrochus\EPF\Models\Artist::class, 'artist_type_id', 'artist_type_id');
    }

    public function primaryMedia()
    {
        return $this->belongsTo(\Atomescrochus\EPF\Models\MediaType::class, 'primary_media_type_id', 'media_type_id');
    }
}
