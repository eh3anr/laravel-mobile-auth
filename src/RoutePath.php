<?php

namespace Eh3anr\LaravelMobileAuth;

class RoutePath
{
    /**
     * Get the route path for the given route name.
     *
     * @param  string  $routeName
     * @param  string  $default
     * @return string
     */
    public static function for(string $routeName, string $default)
    {
        return config('mobile-auth.paths.'.$routeName) ?? $default;
    }
}
