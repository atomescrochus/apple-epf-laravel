<?php

namespace Atomescrochus\EPF\Traits;

trait FeedCredentials
{
    
    public function getCredentials()
    {
        return  (object) [
            'login' => config('apple-epf.user_id'),
            'password' => config('apple-epf.password'),
        ];
    }
}
