<?php

namespace Atomescrochus\EPF\Models\iTunes;

use Atomescrochus\EPF\Traits\ExportDate;
use Illuminate\Database\Eloquent\Model;

class ParentalAdvisory extends Model
{

    use ExportDate;

    protected $connection = 'apple-epf';
    protected $table = 'parental_advisory';
    protected $primaryKey = "parental_advisory_id";
}
