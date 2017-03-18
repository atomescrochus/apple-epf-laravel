<?php

namespace Atomescrochus\EPF\Models\iTunes;

use Illuminate\Database\Eloquent\Model;

class TranslationType extends Model
{

    protected $connection = 'apple-epf';
    protected $table = 'translation_type';
    protected $primaryKey = "translation_type_id";

    protected $casts = [
        //
    ];
}
