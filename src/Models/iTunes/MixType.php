<?php

namespace Atomescrochus\EPF\Models\iTunes;

use Illuminate\Database\Eloquent\Model;

class MixType extends Model
{

    protected $connection = 'apple-epf';
    protected $table = 'mix_type';
    protected $primaryKey = "mix_type_id";

    protected $casts = [
        //
    ];
}
