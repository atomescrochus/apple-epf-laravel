<?php

namespace Atomescrochus\EPF\Models\iTunes;

use Atomescrochus\EPF\Traits\ExportDate;
use Illuminate\Database\Eloquent\Model;

class Storefront extends Model
{

    use ExportDate;

    protected $connection = 'apple-epf';
    protected $table = 'storefront';
    protected $primaryKey = "storefront_id";
}
