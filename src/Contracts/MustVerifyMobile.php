<?php

namespace Eh3anr\LaravelMobileAuth\Contracts;

interface MustVerifyMobile
{
    public function hasVerifiedMobile();

    public function markMobileAsVerified();

    public function sendMobileVerificationNotification();
}
