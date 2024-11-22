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
            $dayName = $this->locale('nl')->translatedFormat('l');
            // return mb_substr($dayName, 0, 2); 
            return $dayName;
        });
    }
}
