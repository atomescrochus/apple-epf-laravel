<?php

namespace Appwapp\EPF\Models\Popularity;

class PaidIpadApplicationPopularityPerGenre extends ApplicationPopularityPerGenre
{
    /**
     * Sets the application_type attribute
     *
     * @return void
     */
    public function setApplicationTypeAttribute()
    {
        $this->attributes['application_type'] = 'paid_ipad';
    }
}
