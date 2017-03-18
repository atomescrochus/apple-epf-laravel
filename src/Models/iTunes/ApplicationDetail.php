<?php

namespace Atomescrochus\EPF\Models\iTunes;

use Illuminate\Database\Eloquent\Model;

class ApplicationDetail extends Model
{

    protected $connection = 'apple-epf';
    protected $table = 'application_detail';
    protected $primaryKey = "application_id";

    protected $casts = [
        //
    ];

    public function application()
    {
        return $this->belongsTo(\Atomescrochus\EPF\Models\Application::class, 'application_id');
    }
}
