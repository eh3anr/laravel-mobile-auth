<?php

namespace Eh3anr\LaravelMobileAuth;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Eh3anr\LaravelMobileAuth\Skeleton\SkeletonClass
 */
class LaravelMobileAuthFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-mobile-auth';
    }
}
