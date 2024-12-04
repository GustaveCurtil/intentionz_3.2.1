<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\PublicEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class SaveController extends Controller
{
    public function save(Request $request, PublicEvent $event){ 

        // zoeken naar user of gast
        $user = auth()->guard()->user();
        if (!$user) {
            $deviceId = Cookie::get('device_id');
            $guest = Guest::where('device_id', $deviceId)->first();
        } else {
            $guest = $user->guest;
        }

        //OPSLAAN - NIET OPSLAAN
        if (!$guest->savedPublicEvents->contains($event->id)) {
            $guest->savedPublicEvents()->attach($event->id);
        } else {
            $guest->savedPublicEvents()->detach($event->id);
        }

        return redirect()->back();
    }
}
