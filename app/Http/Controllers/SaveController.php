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
        $user = Auth::user();
        if (!$user) {
            $deviceId = Cookie::get('device_id');
            $user = Guest::where('device_id',$deviceId)->first(); 
        }

        if (!$user->savedPublicEvents->contains($event->id)) {
            $user->savedPublicEvents()->attach($event->id);
        } else {
            $user->savedPublicEvents()->detach($event->id);
        }

        return redirect()->back();
    }
}
