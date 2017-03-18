<?php

namespace Atomescrochus\EPF\Models\iTunes;

use Illuminate\Database\Eloquent\Model;

class ParentalAdvisory extends Model
{

    protected $connection = 'apple-epf';
    protected $table = 'parental_advisory';
    protected $primaryKey = "parental_advisory_id";

    protected $casts = [
        //
    ];
}
