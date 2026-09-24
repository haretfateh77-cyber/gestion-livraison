<?php

namespace App\Providers;

use App\Listeners\FlashNewRecoveryCodes;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Laravel\Fortify\Events\RecoveryCodesGenerated;
use Laravel\Fortify\Events\TwoFactorAuthenticationConfirmed;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        RecoveryCodesGenerated::class => [
            FlashNewRecoveryCodes::class,
        ],

        TwoFactorAuthenticationConfirmed::class => [
            FlashNewRecoveryCodes::class,
        ],
    ];

    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}