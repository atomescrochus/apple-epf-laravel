<?php

namespace Atomescrochus\EPF\Models\iTunes;

use Atomescrochus\EPF\Traits\ExportDate;
use Illuminate\Database\Eloquent\Model;

class TranslationType extends Model
{

    use ExportDate;

    protected $connection = 'apple-epf';
    protected $table = 'translation_type';
    protected $primaryKey = "translation_type_id";

    protected $casts = [
        //
    ];
}
