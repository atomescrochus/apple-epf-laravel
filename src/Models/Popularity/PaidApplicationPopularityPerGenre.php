<?php

namespace Appwapp\EPF\Models\Popularity;

class PaidApplicationPopularityPerGenre extends ApplicationPopularityPerGenre
{
    /**
     * Sets the application_type attribute
     *
     * @return void
     */
    public function setApplicationTypeAttribute()
    {
        $this->attributes['application_type'] = 'paid';
    }
}
