<?php

namespace Atomescrochus\EPF\Models\iTunes;

use Atomescrochus\EPF\Traits\ExportDate;
use Illuminate\Database\Eloquent\Model;

class MixType extends Model
{

    use ExportDate;

    protected $connection = 'apple-epf';
    protected $table = 'mix_type';
    protected $primaryKey = "mix_type_id";
}
