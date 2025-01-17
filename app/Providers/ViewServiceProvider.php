<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Models\User;
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
            $user = auth()->guard()->user();
            if (!$user) {
                $deviceId = Cookie::get('device_id');

                if (!$deviceId) {
                    $deviceId = request()->get('device_id');
                }

                $guest = Guest::where('device_id', $deviceId)->first();

                if (!$guest) {
                    $guest = request()->get('guest');
                }

                $userEvents=0;

                if ($guest) {
                    $userEvents = $guest->savedPublicEvents()->count();
                    if ($guest->user_id) {
                        $user = User::find($guest->user_id);
                    }
                }
                
            } else {
                $guest = $user->guest;
                if ($guest) {
                    $userEvents = $guest->savedPublicEvents()->count();
                } else {
                    $userEvents = $user->publicEvents()->count();
                }
            }

            $view->with([
                "user" => $user,
                "guest" => $guest,
                "vorigePaginaOpWebsite" => $this->vorigePaginaOpWebsite(), 
                "userEvents" => $userEvents
            ]);
        });
    }

    public function vorigePaginaOpWebsite() {
        $previousUrl = url()->previous();
        $currentHost = parse_url(config('app.url'), PHP_URL_HOST);
        $previousHost = parse_url($previousUrl, PHP_URL_HOST);
    
        return $previousHost === $currentHost;
    }

}
