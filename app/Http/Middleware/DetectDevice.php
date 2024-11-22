<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Guest;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class DetectDevice
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user) {
            $deviceId = Cookie::get('device_id');
            $guest = Guest::where('device_id',$deviceId)->first(); 
    
            if (!$guest) {
                $ipAddress = request()->ip();
                $deviceId = (string) Str::uuid();
                Cookie::queue('device_id', $deviceId, 60 * 24 * 365);
                $guest = Guest::create(['device_id' => $deviceId, 'ip_address' => $ipAddress]);
            } 
            
            $user = $guest;

        }

        return $next($request);
    }
}

