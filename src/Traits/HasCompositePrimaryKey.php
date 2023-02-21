<?php

namespace Appwapp\EPF\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasCompositePrimaryKey
{
    /**
     * Set the keys for a save update query.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     *
     * @throws \Exception
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function setKeysForSaveQuery($query): Builder
    {
        $keys = $this->getKeyName();
        if (! is_array($keys)) {
            throw new \Exception('Primary key should be an array, else do not use `HasCompositePrimaryKey`');
        }

        foreach ($keys as $key) {
            $query->where($key, $this->original[$key] ?? $this->getAttribute($key));
        }

        return $query;
    }
}
