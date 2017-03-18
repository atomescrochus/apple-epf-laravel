<?php

namespace Atomescrochus\EPF\Models\iTunes;

use Illuminate\Database\Eloquent\Model;

class ExportInfo extends Model
{

    protected $connection = 'apple-epf';
    protected $table = 'key_value';
    protected $primaryKey = "key_";

    protected $casts = [
        //
    ];
}
