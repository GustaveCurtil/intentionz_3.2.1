<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Guest;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class GuestController extends Controller
{
    public function createUser(Request $request)
    {
        $incomingFields = $request->validate([
            'gebruiker_naam' => ['required', 'min:2', 'max:25','unique:users,name'],
            'gebruiker_wachtwoord' => ['required', 'min:2', 'max:69'], 
            'gebruiker_wachtwoord2' => ['required', 'same:gebruiker_wachtwoord'], 
            'gebruiker_email' => ['nullable', 'email','unique:users,email']
        ], 
        [
            'gebruiker_naam.unique' => "':input' is al in gebruik",
            'gebruiker_naam.min' => 'gebruikersnaam heeft min. 2 tekens',
            'gebruiker_naam.max' => 'gebruikersnaam heeft max. 25 tekens',
            'gebruiker_wachtwoord.min' => 'wachtwoord heeft min. 2 tekens',
            'gebruiker_wachtwoord.max' => 'wachtwoord heeft max. 69 tekens',
            'gebruiker_wachtwoord2.same' => 'wachtwoord komt niet overeen schat',
            'gebruiker_email.unique' => '":input" is alreeds geregistreerd'
        ]);

        $incomingFields['gebruiker_wachtwoord'] = bcrypt($incomingFields['gebruiker_wachtwoord']);

        /* check of device alreeds een registratie heeft gedaan*/        
        $deviceId = Cookie::get('device_id');
        $deviceHasAccount = Guest::where('device_id', $deviceId)->whereNotNull('user_id')->first();
        if ($deviceHasAccount) {
            $ipAddress = request()->ip();
            $deviceId = (string) Str::uuid();
            Cookie::queue('device_id', $deviceId, 60 * 24 * 365);
            Guest::create(['device_id' => $deviceId, 'ip_address' => $ipAddress]);
        }

        /* devide_id is nog niet gelinkt met een account, dus maak maar een account aan */
        $guest = Guest::where('device_id', $deviceId)->first();
        $userData = [
            'name' => $incomingFields['gebruiker_naam'],    
            'password' => $incomingFields['gebruiker_wachtwoord'],
            'email' => $incomingFields['gebruiker_email'],
            'role' => 'gebruiker',
        ];
        $user = User::create($userData);
        auth()->guard()->login($user);
        $guest->user_id = $user->id;
        $guest->save();


        return redirect('/');
    }

    public function devicelink(Request $request) 
    {

        $user = Auth::user();
        $deviceId = Cookie::get('device_id');

        if (!$user->guest) {
            // Handle the case when there is no associated guest record for the user
            // Example: You could create a new guest record here, if required.
            return redirect('/instellingen')->with('error', 'Geen gast record gevonden.');
        }
        
        if ($deviceId ===  $user->guest->device_id) {
            $deviceId = (string) Str::uuid();
            Cookie::queue('device_id', $deviceId, 60 * 24 * 365);
        } else {
            Cookie::queue('device_id', $user->guest->device_id, 60 * 24 * 365);
        }
        return redirect('/instellingen');
    }
}
