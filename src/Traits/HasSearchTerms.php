<?php

namespace Appwapp\EPF\Traits;

trait HasSearchTerms
{
    /**
     * Gets the search_terms attribute
     *
     * @param string $value
     *
     * @return array
     */
    public function getSearchTermsAttribute($value)
    {
        return explode(' ', $value);
    }

    /**
     * Sets the search_terms attribute
     *
     * @param mixed $value
     *
     * @return void
     */
    public function setSearchTermsAttributes($value)
    {
        if (is_array($value)) {
            $this->attributes['search_terms'] = implode(' ', $value);
        } else {
            $this->attributes['search_terms'] = $value;
        }
    }
}
