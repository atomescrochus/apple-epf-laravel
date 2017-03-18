<?php

namespace Atomescrochus\EPF\Models\iTunes;

use Illuminate\Database\Eloquent\Model;

class Storefront extends Model
{

    protected $connection = 'apple-epf';
    protected $table = 'storefront';
    protected $primaryKey = "storefront_id";

    protected $casts = [
        //
    ];
}
