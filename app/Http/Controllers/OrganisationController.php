<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Organisation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrganisationController extends Controller
{
    public function createOrganisation(Request $request)
    {
        $incomingFields = $request->validate([
            'organisatie_naam' => ['required', 'min:2', 'max:30','unique:users,name'],
            'organisatie_wachtwoord' => ['required', 'min:2', 'max:69'], 
            'organisatie_wachtwoord2' => ['required', 'same:organisatie_wachtwoord'], 
            'organisatie_email' => ['nullable', 'email','unique:users,email'],
            'organisatie_adres' => ['nullable'],
            'organisatie_stad' => ['nullable'],
            'organisatie_url_locatie' => ['nullable', 'url'],
            'organisatie_url_website' => ['nullable', 'url']
        ], 
        [
            'organisatie_naam.unique' => "':input' is al in gebruik",
            'organisatie_naam.min' => 'naam organisatie heeft min. 2 tekens',
            'organisatie_naam.max' => 'naam organisatie heeft max. 30 tekens',
            'organisatie_wachtwoord.min' => 'wachtwoord heeft min. 2 tekens',
            'organisatie_wachtwoord.max' => 'wachtwoord heeft max. 69 tekens',
            'organisatie_wachtwoord2.same' => 'wachtwoord komt niet overeen schat',
            'organisatie_email.unique' => "':input' is al geregistreerd.", 
        ]);

        $incomingFields['organisatie_wachtwoord'] = bcrypt($incomingFields['organisatie_wachtwoord']);

        $userData = [
            'name' => $incomingFields['organisatie_naam'],    
            'password' => $incomingFields['organisatie_wachtwoord'],
            'email' => $incomingFields['organisatie_email'],
            'role' => 'organisatie',
        ];

        $user = User::create($userData);

        auth()->guard()->login($user);

        $organisationData = [
            'user_id' => $user->id,
            'adres' => $incomingFields['organisatie_adres'],
            'stad' => $incomingFields['organisatie_stad'], 
            'url_locatie' => $incomingFields['organisatie_url_locatie'],
            'url_website' => $incomingFields['organisatie_url_website']
        ];

        Organisation::create($organisationData);

        return redirect('/');
    }

    public function wijzigAdres(Request $request) {
        $incomingFields = $request->validate([
            'hidden_adres' => ['nullable'],
            'hidden_stad' => ['nullable'],
            'hidden_url_locatie' => ['nullable'],
            'hidden_url_website' => ['nullable']
        ]);

        $user = Auth::user();
        
        $organisationData = [
            'adres' => $incomingFields['hidden_adres'],
            'stad' => $incomingFields['hidden_stad'],
        ];

        $validator = Validator::make([], []);
        if ($incomingFields['hidden_url_locatie'] !== null && !filter_var($incomingFields['hidden_url_locatie'], FILTER_VALIDATE_URL)) {
            $validator->errors()->add('url_locatie', 'dit is geen geldige url');
        } else {
            $organisationData['url_locatie'] = $incomingFields['hidden_url_locatie'];
        };
        if ($incomingFields['hidden_url_website'] !== null && !filter_var($incomingFields['hidden_url_website'], FILTER_VALIDATE_URL)) {
            $validator->errors()->add('url_website', 'dit is geen geldige url');
        } else {
            $organisationData['url_website'] = $incomingFields['hidden_url_website'];
        }
    
        $organisation = Organisation::where('user_id', $user->id)->firstOrFail(); 
        $organisation->update($organisationData);

        return redirect()->back()->withErrors($validator)->withInput();
    }
}
