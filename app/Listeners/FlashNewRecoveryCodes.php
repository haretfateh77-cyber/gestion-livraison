<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Log;

class FlashNewRecoveryCodes
{
    public function handle($event): void
    {
        Log::info('LISTENER DECLENCHE', ['event' => get_class($event)]);

        $user = $event->user->fresh();

        if ($user && $user->two_factor_recovery_codes) {
            Log::info('CODES TROUVES, on les flash en session');
            session()->flash('recovery_codes', $user->recoveryCodes());
        } else {
            Log::info('PAS DE CODES TROUVES POUR CET USER');
        }
    }
}