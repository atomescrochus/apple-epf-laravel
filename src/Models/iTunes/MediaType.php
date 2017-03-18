<?php

namespace Atomescrochus\EPF\Models\iTunes;

use Illuminate\Database\Eloquent\Model;

class MediaType extends Model
{

    protected $connection = 'apple-epf';
    protected $table = 'media_type';
    protected $primaryKey = "media_type_id";

    protected $casts = [
        //
    ];
}
