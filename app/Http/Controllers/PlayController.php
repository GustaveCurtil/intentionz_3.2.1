<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Organisation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class PlayController extends Controller
{
    public function kleuren(Request $request)
    {
        
        $incomingFields = $request->validate([
            'kleur_achtergrond' => 'required',
            'kleur_thema' => 'required',
            'kleur_thema2' => 'required',
            'kleur_thema3' => 'required',
            'kleur_tekst' => 'required',
        ]);

        $user = Auth::user();
        if ($user) {
            $profile = Guest::where('user_id', $user->id)->first();
            if (!$profile) {
                $profile = Organisation::where('user_id', $user->id)->first();   
            }
        } else {
            $deviceId = Cookie::get('device_id');
            $profile = Guest::where('device_id', $deviceId)->first();         
        }

        $profile->update($incomingFields);
        return redirect()->back();

    }

    public function kleurenResetten()
    {
        $data['kleur_achtergrond'] = null;
        $data['kleur_thema'] = null;
        $data['kleur_thema2'] = null;
        $data['kleur_thema3'] = null;
        $data['kleur_tekst'] = null;

        $user = Auth::user();
        if ($user) {
            $profile = Guest::where('user_id', $user->id)->first();
            if (!$profile) {
                $profile = Organisation::where('user_id', $user->id)->first();   
            }
        } else {
            $deviceId = Cookie::get('device_id');
            $profile = Guest::where('device_id', $deviceId)->first();         
        }
        $profile->update($data);

        return redirect('/instellingen');
    }
}
