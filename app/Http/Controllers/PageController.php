<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Guest;
use App\Models\PublicEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class PageController extends Controller
{
    public function thuis() 
    {

        $events = PublicEvent::orderBy('datum', 'asc')->get();
        $categoriesAll = PublicEvent::select('categorie')
        ->groupBy('categorie')
        ->orderByRaw('COUNT(*) DESC')
        ->limit(8)
        ->pluck('categorie');

        $steden = PublicEvent::select('stad')->groupBy('stad')->orderByRaw('COUNT(*) DESC')->limit(6)->pluck('stad');
        $stedenMetCategories = [];

        foreach ($steden as $stad) {
            $stedenMetCategories[$stad] = PublicEvent::where('stad', $stad)
            ->select('categorie', DB::raw('COUNT(*) as category_count'))
            ->groupBy('categorie')
            ->orderByDesc('category_count')
            ->limit(8)
            ->pluck('categorie');
        }

        foreach ($events as $event) {
            $event->tijd = Carbon::parse($event->tijd)->format('H\ui');
            $eventDate = Carbon::parse($event->datum);
            // if ($eventDate->isToday()) {
            //     $event->datum = 'vandaag';
            // } elseif ($eventDate->isTomorrow()) {
            //     $event->datum = 'morgen ' . $eventDate->translatedFormat('d/m/Y');
            // } else {
            //     $dagAfkorting = $eventDate->eersteTweeLetters();
            //     $event->datum = $dagAfkorting . ' ' . $eventDate->translatedFormat('d/m/Y');
            // }
            $dagAfkorting = $eventDate->eersteTweeLetters();
            $event->datum = $dagAfkorting . ' ' . $eventDate->translatedFormat('d/m/Y');
        }

        return view('1_evenementen', ['events' => $events, 'categoriesAll' => $categoriesAll, 'steden' => $stedenMetCategories]);
    }

    public function overzichtGebruiker() 
    {

        $events = PublicEvent::orderBy('datum', 'asc')->get();
        foreach ($events as $event) {
            $event->tijd = Carbon::parse($event->tijd)->format('H\ui');
            $eventDate = Carbon::parse($event->datum);
            // if ($eventDate->isToday()) {
            //     $event->datum = 'vandaag';
            // } elseif ($eventDate->isTomorrow()) {
            //     $event->datum = 'morgen ' . $eventDate->translatedFormat('d/m/Y');
            // } else {
            //     $dagAfkorting = $eventDate->eersteTweeLetters();
            //     $event->datum = $dagAfkorting . ' ' . $eventDate->translatedFormat('d/m/Y');
            // }
            $dagAfkorting = $eventDate->eersteTweeLetters();
            $event->datum = $dagAfkorting . ' ' . $eventDate->translatedFormat('d/m/Y');
        }
        return view('2_overzicht_gebruiker', ['events' => $events]);

    }

    public function overzichtOrganisatie() 
    {
        $user = auth()->guard()->user();
        $events = PublicEvent::orderBy('datum', 'asc')->get();
        foreach ($events as $event) {
            $event->tijd = Carbon::parse($event->tijd)->format('H\ui');
            $eventDate = Carbon::parse($event->datum);
            // if ($eventDate->isToday()) {
            //     $event->datum = 'vandaag';
            // } elseif ($eventDate->isTomorrow()) {
            //     $event->datum = 'morgen ' . $eventDate->translatedFormat('d/m/Y');
            // } else {
            //     $dagAfkorting = $eventDate->eersteTweeLetters();
            //     $event->datum = $dagAfkorting . ' ' . $eventDate->translatedFormat('d/m/Y');
            // }
            $dagAfkorting = $eventDate->eersteTweeLetters();
            $event->datum = $dagAfkorting . ' ' . $eventDate->translatedFormat('d/m/Y');
        }
        return view('2_overzicht_organisatie', ['events' => $events]);
    }

    public function aanmaken() 
    {
        $user = Auth::user();
        if ($user->role === 'organisatie') {
            $categoriesAll = PublicEvent::select('categorie')
            ->groupBy('categorie')
            ->orderByRaw('COUNT(*) DESC')
            ->pluck('categorie');

            return view('3_aanmaken', ['categories' => $categoriesAll]);
        }

        return view('3_aanmaken');
    }

    public function aanmakenOrganisatie() 
    {
        $user = Auth::user();
        if ($user->role === 'organisatie') {
            dd('lol');
        }
        $categoriesAll = PublicEvent::select('categorie')
        ->groupBy('categorie')
        ->orderByRaw('COUNT(*) DESC')
        ->pluck('categorie');

        return view('3_aanmaken', ['categories' => $categoriesAll]);
    }

    public function instellingen() 
    {

        return view('4_instellingen');
    }


    public function aanmelden() 
    {
        return view('0_aanmelden');
    }

    public function over() 
    {
        return view('5_over');
    }

    public function zen() 
    {
        return view('6_zen');
    }

    public function publiekEvenement($id, $titel) 
    {
        $event = publicEvent::findOrFail($id);
        $event->tijd = Carbon::parse($event->tijd)->format('H\ui');
        $eventDate = Carbon::parse($event->datum);
        if ($eventDate->isToday()) {
            $event->datum = 'vandaag';
        } elseif ($eventDate->isTomorrow()) {
            $event->datum = 'morgen ' . $eventDate->translatedFormat('d/m/Y');
        } else {
            $dagAfkorting = $eventDate->eersteTweeLetters();
            $event->datum = $dagAfkorting . ' ' . $eventDate->translatedFormat('d/m/Y');
        }
        $dagAfkorting = $eventDate->eersteTweeLetters();
        $event->datum = $dagAfkorting . ' ' . $eventDate->translatedFormat('d/m/Y');
        return view('evenement_publiek', ["event" => $event]);
    }

    public function priveEvenement() 
    {
        return view('evenement_prive');
    }



}
