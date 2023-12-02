<?php

namespace Eh3anr\LaravelMobileAuth\Rules;

use Closure;
use Eh3anr\LaravelMobileAuth\LaravelMobileAuth;
use Eh3anr\LaravelOtp\LaravelOtpFacade;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Auth;

class Otp implements ValidationRule
{
    public function __construct(
        public string $key,
    )
    {

    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!LaravelOtpFacade::validateOtp($this->key . Auth::user()->{LaravelMobileAuth::$mobileVerificationKey}, $value)) {
            $fail('The :attribute is invalid.');
        }
    }
}
