<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Models\Guest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $user = Auth::user();
            if (!$user) {
                $deviceId = Cookie::get('device_id');
                $user = Guest::where('device_id', $deviceId)->first();
            }
            $view->with(['user' => $user]);
        });
    }
}
