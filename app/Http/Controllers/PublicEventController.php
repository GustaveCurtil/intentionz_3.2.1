<?php

namespace App\Http\Controllers;

use App\Models\PublicEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

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
            'subcategorie' => 'nullable',
            'url_evenement' => 'nullable|url',
            'beschrijving' => 'nullable|string|max:5000',
            'kleur' => 'required',
            'achtergrond_pad' => 'nullable',
            'foto' => 'nullable|file|mimes:jpg,jpeg,png,gif|max:15240',
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
        $incomingFields['subcategorie'] = strtolower($incomingFields['subcategorie']);

        // $incomingFields['beschrijving'] = nl2br(strip_tags($incomingFields['beschrijving']));

        $incomingFields['user_id'] = auth()->guard()->id();

        PublicEvent::create($incomingFields);

        return redirect()->route('overzicht-organisatie');
    }

    public function editEvent(PublicEvent $event, Request $request)
    {
        $incomingFields = $request->validate([
            'titel' => 'required|string|max:100',
            'datum' => 'required|date',
            'tijd' => 'required|date_format:H:i',
            'adres' => 'nullable|string|max:50',
            'stad' => 'required|min:2',
            'url_locatie' => 'nullable|url',
            'categorie' => 'nullable',
            'subcategorie' => 'nullable',
            'url_evenement' => 'nullable|url',
            'beschrijving' => 'nullable|string|max:5000',
            'kleur' => 'required',
            'achtergrond_pad' => 'nullable',
            'foto' => 'nullable|file|mimes:jpg,jpeg,png,gif|max:15240',
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
        $incomingFields['subcategorie'] = strtolower($incomingFields['subcategorie']);

        // $incomingFields['beschrijving'] = nl2br(strip_tags($incomingFields['beschrijving']));

        $incomingFields['user_id'] = auth()->guard()->id();

        $event->update($incomingFields);

        return redirect()->route('overzicht-organisatie');
    }
    
    public function naarEditor(PublicEvent $event) {
        $user = Auth::user();

        if ($event->user_id !== $user->id) {
            dd('problematique');
        }

        if ($user->role === 'organisatie') {
            $achtergronden = [
                'bliksem.gif',
                'bloemen.gif',
                'boom.png',
                'DnD.gif',
                'epilepsie.gif',
                'hartjes.gif',
                'kleurenhartjes.gif',
                'matrix.gif',
                'regenboog.png',
                'ruimte.gif',
                'schrammen.png',
                'vlinders.gif',
                'vuurwerk.gif',
                'wolken.jpg',
            ];
            $labels = $this->labelScraper();
        }

        $event->tijd = Carbon::parse($event->tijd)->format('H:i');

        return view('3_aanmaken', [
            'event' => $event,
            'categories' => $labels, 
            'achtergronden' => $achtergronden
        ]);
    }

    public function aanmaken() 
    {
        $user = Auth::user();
        if ($user->role === 'organisatie') {
            $achtergronden = [
                'bliksem.gif',
                'bloemen.gif',
                'boom.png',
                'DnD.gif',
                'epilepsie.gif',
                'hartjes.gif',
                'kleurenhartjes.gif',
                'matrix.gif',
                'regenboog.png',
                'ruimte.gif',
                'schrammen.png',
                'vlinders.gif',
                'vuurwerk.gif',
                'wolken.jpg',
            ];
            // Fetch labels using the labelScraper() method
            $labels = $this->labelScraper();
    
            // Pass the labels to the view
            return view('3_aanmaken', [
                'categories' => $labels, 
                 'achtergronden' => $achtergronden,
            ]);
        }
    
        return view('3_aanmaken');
    }

    public function labelScraper() {
        // Fetch all labels grouped by category
        $categories = ['film', 'muziek', 'voorstelling', 'dansen', 'expo', 'workshop'];
        
        $labels = [];
    
        foreach ($categories as $categorie) {
            $labels[$categorie] = PublicEvent::select('subcategorie')
                ->whereNotNull('subcategorie')
                ->where('categorie', $categorie)
                ->groupBy('subcategorie')
                ->orderByRaw('COUNT(*) DESC')
                ->pluck('subcategorie');
        }
    
        return $labels; // Return labels for all categories
    }
    
}

