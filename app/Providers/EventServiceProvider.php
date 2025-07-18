<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use App\Listeners\LogSuccessfulLogin;
use App\Listeners\LogSuccessfulLogout;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     */
    protected $listen = [
        Login::class => [
            LogSuccessfulLogin::class,
        ],
        Logout::class => [
            LogSuccessfulLogout::class,
        ],
    ];

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
