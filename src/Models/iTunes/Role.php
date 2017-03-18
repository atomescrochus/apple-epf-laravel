<?php

namespace Atomescrochus\EPF\Models\iTunes;

use Atomescrochus\EPF\Traits\ExportDate;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    use ExportDate;

    protected $connection = 'apple-epf';
    protected $table = 'role';
    protected $primaryKey = "role_id";
}
