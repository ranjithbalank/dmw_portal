<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;

class LogSuccessfulLogout
{
    /**
     * Handle the event.
     */
    public function handle(Logout $event): void
    {
        if ($event->user) {
            $event->user->update([
                'last_logout_at' => now(),
            ]);
        }
    }
}
