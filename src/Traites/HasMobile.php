<?php

namespace Eh3anr\LaravelMobileAuth\traites;

use Eh3anr\LaravelMobileAuth\Notifications\VerifyMobile;
use Propaganistas\LaravelPhone\Casts\E164PhoneNumberCast;

trait HasMobile
{
    public function initializeHasMobile(): void
    {
        $this->fillable[] = 'mobile';

        $this->casts['mobile'] = E164PhoneNumberCast::class;
    }

    public function hasVerifiedMobile(): bool
    {
        return ! is_null($this->mobile_verified_at);
    }

    public function markMobileAsVerified(): bool
    {
        return $this->forceFill([
            'mobile_verified_at' => $this->freshTimestamp(),
        ])->save();
    }

    public function sendMobileVerificationNotification(): void
    {
        $this->notify(new VerifyMobile);
    }
}
