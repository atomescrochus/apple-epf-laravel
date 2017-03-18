<?php

namespace Atomescrochus\EPF\Models\iTunes;

use Illuminate\Database\Eloquent\Model;

class Mix extends Model
{

    protected $connection = 'apple-epf';
    protected $table = 'mix';
    protected $primaryKey = "mix_id";

    protected $casts = [
        //
    ];

    public function collections()
    {
        return $this->belongsToMany(\Atomescrochus\EPF\Models\Collection::class, 'mix_collection', 'mix_id', 'collection_id');
    }

    public function songs()
    {
        return $this->belongsToMany(\Atomescrochus\EPF\Models\Song::class, 'song_mix', 'mix_id', 'song_id');
    }

    public function type()
    {
        return $this->belongsTo(\Atomescrochus\EPF\Models\MixType::class, 'mix_type_id', 'mix_type_id');
    }
}
