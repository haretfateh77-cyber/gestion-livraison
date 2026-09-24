<?php

namespace App\Providers;

use App\Listeners\FlashNewRecoveryCodes;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Events\RecoveryCodesGenerated;
use Laravel\Fortify\Events\TwoFactorAuthenticationConfirmed;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Event::listen(RecoveryCodesGenerated::class, FlashNewRecoveryCodes::class);
        Event::listen(TwoFactorAuthenticationConfirmed::class, FlashNewRecoveryCodes::class);
    }
}