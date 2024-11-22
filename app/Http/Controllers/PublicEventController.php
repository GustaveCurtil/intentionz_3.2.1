<?php

namespace App\Http\Controllers;

use App\Models\PublicEvent;
use Illuminate\Http\Request;

class PublicEventController extends Controller
{
    public function createEvent(Request $request)
    {
        $incomingFields = $request->validate([
            'titel' => 'required|string|max:100',
            'datum' => 'required|date',
            'tijd' => 'required|date_format:H:i',
            'adres' => 'nullable|string|max:50',
            'stad' => 'required|min:2',
            'url_locatie' => 'nullable|url',
            'categorie' => 'nullable',
            'url_evenement' => 'nullable|url',
            'beschrijving' => 'nullable|string|max:5000',
            'kleur' => 'required',
            'achtergrond_pad' => 'nullable',
            'foto' => 'nullable|file|mimes:jpg,jpeg,png,gif|max:10240',
            'miniatuur' => 'nullable|file|mimes:jpg,jpeg,png,gif',
            'zoom' => 'Integer',
            'verticaal' => 'Integer',
            'horizontaal' => 'Integer',
        ]);

        if ($request->hasFile('foto')) {
            $poster = $request->file('foto');
            $miniatuur = $request->file('miniatuur');
            $newImageName = $request->datum . '-' . preg_replace('/[^a-zA-Z0-9_-]/', '_', $request->titel) . '.' . $request->miniatuur->extension();
            $miniatuur->storeAs('miniaturen', $newImageName, 'public');
            $poster->storeAs('posters', $newImageName, 'public');
            $incomingFields['foto_pad'] = $newImageName;
        }

        $incomingFields['categorie'] = strtolower($incomingFields['categorie']);
        // $incomingFields['beschrijving'] = nl2br(strip_tags($incomingFields['beschrijving']));

        $incomingFields['user_id'] = auth()->guard()->id();

        PublicEvent::create($incomingFields);

        return redirect()->route('overzicht-organisatie');
    }
}

