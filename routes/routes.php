<?php

use Eh3anr\LaravelMobileAuth\LaravelMobileAuth;
use Eh3anr\LaravelMobileAuth\Rules\Otp;
use Eh3anr\LaravelOtp\LaravelOtpFacade;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Eh3anr\LaravelMobileAuth\RoutePath;
use Laravel\Fortify\Fortify;

Route::group(['middleware' => config('fortify.middleware', ['web'])], function () {
    // todo: set config
    $verificationLimiter = config('fortify.limiters.verification', '6,1');


    // verify do halat dare yani 2 step
    Route::get(RoutePath::for('verification.form', '/mobile/verify'), function (Request $request) {

        if ($request->user()->hasVerifiedMobile()) {
            return $request->wantsJson()
                ? new JsonResponse('', 204)
                : redirect()->intended(); // todo: add default intended
        }

        if (LaravelOtpFacade::getHashedOtp('mobile-verification:' . $request->user()->{LaravelMobileAuth::$mobileVerificationKey})) {
            // forme validate
            return \Inertia\Inertia::render('Auth/VerifyMobile');
        } else {
            // forme darkhaste code
            // $request->user()->sendMobileVerificationNotification();
            return 18;
        }

    })->middleware([config('fortify.auth_middleware', 'auth') . ':' . config('fortify.guard')])
        ->name('mobileVerification.form');

    Route::post(RoutePath::for('verification.send', '/mobile/verification-notification'), function (Request $request) {
        if ($request->user()->hasVerifiedMobile()) {
            return $request->wantsJson()
                ? new JsonResponse('', 204)
                : redirect()->intended(); // todo: add default intended
        }

        // agar hanooz otp expire nashode bargard be form
        if (LaravelOtpFacade::getHashedOtp('mobile-verification:' . $request->user()->{LaravelMobileAuth::$mobileVerificationKey})) {
            return redirect()->route('mobileVerification.form');
        }

        $request->user()->sendMobileVerificationNotification();

        return $request->wantsJson()
            ? new JsonResponse('', 202)
            : back()->with('status', Fortify::VERIFICATION_LINK_SENT); // todo: replace fortify

    })->middleware([config('fortify.auth_middleware', 'auth') . ':' . config('fortify.guard'), 'throttle:' . $verificationLimiter])
        ->name('mobileVerification.send');

    Route::post(RoutePath::for('verification.verify', '/mobile/verify'), function (Request $request) {
        if ($request->user()->hasVerifiedMobile()) {
            return $request->wantsJson()
                ? new JsonResponse('', 204)
                : redirect()->intended(); // todo: add default intended
        }

        $request->validate([
            'otp' => ['required', 'string', new Otp('mobile-verification:')]
        ]);

        $request->user()->markMobileAsVerified();


        return 12;
    })->name('mobileVerification.verify');
});
