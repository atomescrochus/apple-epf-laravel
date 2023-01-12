<?php

namespace Appwapp\EPF\Traits;

trait ExportDate
{
    public function getExportDateAttribute($timestamp)
    {
        //dirty, but working hack
        $millisecondsToMicroseconds = substr($timestamp, 0, -3);

        return \Carbon\Carbon::createFromTimestamp($millisecondsToMicroseconds);
    }
}
