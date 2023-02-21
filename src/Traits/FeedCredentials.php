<?php

namespace Appwapp\EPF\Traits;

trait FeedCredentials
{
    /**
     * Get the Apple EPF user credentials from configuration.
     *
     * @return object
     */
    public function getCredentials(): object
    {
        return (object) [
            'login'    => config('apple-epf.user_id'),
            'password' => config('apple-epf.password'),
        ];
    }
}
