<?php

namespace Atomescrochus\EPF\Models\iTunes;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    protected $connection = 'apple-epf';
    protected $table = 'role';
    protected $primaryKey = "role_id";

    protected $casts = [
        //
    ];
}
