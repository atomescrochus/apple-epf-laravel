<?php

namespace Appwapp\EPF\Traits;

use Illuminate\Support\Carbon;

trait ExportDate
{
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
