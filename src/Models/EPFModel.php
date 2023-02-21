<?php

namespace Appwapp\EPF\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;

class EPFModel extends Model
{
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
     * Constructs a new instance.
     *
     * @param  array  $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        // Set the configuration from the config
        $this->setConnection(config('apple-epf.database_connection'));
    }
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

    /**
     * Gets the table name statically.
     *
     * @return string
     */
    public static function getTableName(): string
    {
        return with(new static )->getTable();
    }
}
