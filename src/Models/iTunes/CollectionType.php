<?php

namespace Atomescrochus\EPF\Models\iTunes;

use Illuminate\Database\Eloquent\Model;

class CollectionType extends Model
{

    protected $connection = 'apple-epf';
    protected $table = 'collection_type';
    protected $primaryKey = "collection_type_id";

    protected $casts = [
        //
    ];

    public function collections()
    {
        return $this->hasMany(Collection::class, 'collection_type_id');
    }
}
