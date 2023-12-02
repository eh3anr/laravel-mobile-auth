<?php

namespace Eh3anr\LaravelMobileAuth\Http\Responses;
use Illuminate\Http\JsonResponse;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;
use Laravel\Fortify\Fortify;

class RegisterResponse implements RegisterResponseContract
{

    /**
     * @inheritDoc
     */
    public function toResponse($request)
    {
        return $request->wantsJson()
            ? new JsonResponse('', 201)
            : redirect()->intended(route('mobileVerification.form'))->with('status', Fortify::VERIFICATION_LINK_SENT); // todo: set from config, !with ham kar nemikone
    }
}
