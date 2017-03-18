<?php

namespace Atomescrochus\EPF\Models\iTunes;

use Atomescrochus\EPF\Traits\ExportDate;
use Illuminate\Database\Eloquent\Model;

class ExportInfo extends Model
{

    use ExportDate;

    protected $connection = 'apple-epf';
    protected $table = 'key_value';
    protected $primaryKey = "key_";
}
