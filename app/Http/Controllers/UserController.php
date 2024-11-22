<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function login(Request $request) 
    {

        $incomingFields = $request->validate([
            'naam' => ['required'],
            'wachtwoord' => ['required']
        ]);

        $username = [
            'name' => $incomingFields['naam'], 
            'password' => $incomingFields['wachtwoord'], 
        ];

        $useremail = [
            'email' => $incomingFields['naam'], 
            'password' => $incomingFields['wachtwoord']
        ];
        

        //proberen inloggen
        if (auth()->guard()->attempt($username) || auth()->guard()->attempt($useremail)) {
            $request->session()->regenerate();

            return redirect('/');
        } 

        //errorhandling indien niet kunnen inloggen
        $tryName = User::where('name', $incomingFields['naam'])->first();
        $tryEmail = User::where('email', $incomingFields['naam'])->first();

        // Create a new validator instance for adding custom errors
        $validator = Validator::make([], []); // Beginnen met een lege validator

        if ($tryName || $tryEmail) {
            // If username/email exists but password is wrong
            $validator->errors()->add('login_wachtwoord', 'wachtwoord incorrect');
        } else {
            // If no user exists with this username/email
            $validator->errors()->add('login_naam', "'" . $incomingFields['naam']. "'" . ' bestaat niet');
        }


        // Redirect back with the custom errors and input
        return redirect()->back()->withErrors($validator)->withInput();
    }

    public function logout()
    {
        auth()->guard()->logout();
        return redirect('/');
    }

    public function delete(Request $request)
    {
        if (!$request->has('verwijder-account') || !$request->has('verwijder-zeker')) {
            return back()->with('error', 'ge moet wel zeker zijn hè.');
        }

        // Perform account deletion
        $user = Auth::user();
        $user->delete();
        return redirect('/');
    }

    public function wijzignaam(Request $request)
    {
        $incomingFields = $request->validate([
            'naam' => ['required', 'min:2', 'max:25','unique:users,name'],
        ], 
        [
            'naam.unique' => "':input' is al in gebruik",
            'gebruiker_naam.min' => 'naam heeft min. 2 tekens',
            'gebruiker_naam.max' => 'naam heeft max. 25 tekens',
        ]);

        $user = Auth::user();
        $user->name = $incomingFields['naam'];
        $user->save();

        return redirect('/instellingen');
    }

    
    public function wijzigwachtwoord(Request $request)
    {
        $incomingFields = $request->validate([
            'wachtwoord-oud' => ['required'],
            'wachtwoord' => ['required'],
            'wachtwoord2' => ['required'], 
        ]);

        $user = Auth::user();

        if (!Hash::check($incomingFields['wachtwoord-oud'], $user->password)) {
            return back()->withErrors(['wachtwoord-oud' => 'foutief wachtwoord']);
        }

        if ($incomingFields['wachtwoord'] !== $incomingFields['wachtwoord2']) {
            return back()->withErrors(['wachtwoord' => 'wachtwoorden komen niet overeen']);
        }

        $incomingFields['wachtwoord'] = bcrypt($incomingFields['wachtwoord']);

        $user->password = $incomingFields['wachtwoord'];
        $user->save();

        return redirect('/instellingen');
    }

    public function wijzigemail(Request $request)
    {
        $incomingFields = $request->validate([
            'email' => ['required', 'unique:users,email'],
        ]);

        $existingEmail = User::where('email', $incomingFields['email'])->first();
        if ($existingEmail) {
            return back()->withErrors(['email' => 'Deze email wordt al door iemand gebruikt.']);
        }

        $user = Auth::user();
        $user->email = $incomingFields['email'];
        $user->save();

        return redirect('/instellingen');
    }

}
