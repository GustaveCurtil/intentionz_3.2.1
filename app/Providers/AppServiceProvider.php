<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::if('gebruiker', function () {
            return Auth::check() && Auth::user()->role === 'gebruiker';
        });

        Blade::if('organisatie', function () {
            return Auth::check() && Auth::user()->role === 'organisatie';
        });

        Carbon::macro('eersteTweeLetters', function () {
            $dayName = $this->locale('nl')->translatedFormat('l'); // Haal de volledige naam van de dag op in het Nederlands
            $shortDayName = mb_substr($dayName, 0, 2); // Haal de eerste twee letters van de dagnaam
            return ucfirst($shortDayName); // Zet de eerste letter van de afkorting om naar een hoofdletter
        });
    }
}
