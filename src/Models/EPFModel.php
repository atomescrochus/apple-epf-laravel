<?php

namespace Appwapp\EPF\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;

class EPFModel extends Model
{
    /**
     * The database connection that should be used by the model.
     *
     * @var string
     */
    protected $connection = 'apple-epf';

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Get the export_date attribute
     *
     * @param mixed $timestamp
     *
     * @return Carbon
     */
    public function getExportDateAttribute($timestamp): Carbon
    {
        // Reduce microseconds to milliseconds
        return Carbon::createFromTimestamp(substr($timestamp, 0, -3));
    }
}
