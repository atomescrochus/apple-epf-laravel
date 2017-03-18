<?php

namespace Atomescrochus\EPF\Models\iTunes;

use Illuminate\Database\Eloquent\Model;

class CollectionTranslation extends Model
{

    protected $connection = 'apple-epf';
    protected $table = 'collection_translation';
    protected $primaryKey = "collection_id";

    protected $casts = [
        //
    ];

    public function collection()
    {
        return $this->belongsTo(\Atomescrochus\EPF\Models\Collection::class, 'collection_id');
    }
}
