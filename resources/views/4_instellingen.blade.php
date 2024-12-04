@extends('_layouts.head')

@section('title', 'instellingen')

@section('head')
@include('_partials.metadata')
<script src="{{asset('js/loadingtime.js')}}" defer></script>
@endsection

@section('main')
<main>
    <section>
        <h3>themakleurtjes aanpassen</h3>
        <form action="kleuren" method="post" id="kleuren">
            @csrf
            <input type="color" name="kleur_achtergrond" id="kleur_achtergrond" value="{{ $guest->kleur_achtergrond ?? $user->organisation->kleur_achtergrond ?? '#cedbcf' }}">
            <input type="color" name="kleur_thema" id="kleur_thema" value="{{ $guest->kleur_thema ?? $user->organisation->kleur_thema ?? '#f5aeb7' }}">
            <input type="color" name="kleur_thema2" id="kleur_thema2" value="{{ $guest->kleur_thema2 ?? $user->organisation->kleur_thema2 ?? '#cac9e8' }}">
            <input type="color" name="kleur_thema3" id="kleur_thema3" value="{{ $guest->kleur_thema3 ?? $user->organisation->kleur_thema3 ?? '#f5f5dc' }}">
            <input type="color" name="kleur_tekst" id="kleur_tekst" value="{{ $guest->kleur_tekst ?? $user->organisation->kleur_tekst ?? '#4b4b4b' }}">
            <input type="submit" value="kleuren toepassen">
        </form>
        <p>surf naar <a href="/kleuren-resetten">{{ request()->getHost() }}/reset</a> om terug mooie kleuren te hebben.</p>
    </section>
    @organisatie
    <section id="standaard-gegevens">
        <h3>automatisch invullen bij evenementen</h3>
        <form action="wijzig-adres#standaard-gegevens" method="post">
            @csrf
            <div class="adres">
                <input type="text" name="adres" id="adres" placeholder="straat + nr{{ $user->organisation->adres ? ": " . $user->organisation->adres : ""}}" value="{{ $user->organisation->adres ? $user->organisation->adres : ""}}">
                <input type="text" name="stad" id="stad" placeholder='stad{{ $user->organisation->stad ? ": " . $user->organisation->stad : ""}}' value="{{ $user->organisation->stad ? $user->organisation->stad : ""}}">    
                <input type="text" name="url_locatie" id="url_locatie" placeholder="{{ $errors->has('url_locatie') ? $errors->first('url_locatie') : "url locatie" . ($user->organisation->url_locatie ? ": " . $user->organisation->url_locatie : "")}}" value="{{ $user->organisation->url_locatie ? $user->organisation->url_locatie : ""}}">
                <div onclick="window.open('https://www.openstreetmap.org', '_blank')" id="openstreetmap">openstreetmap.org</div>
            </div>
            <input type="text" name="url_website" id="url_website" placeholder="{{ $errors->has('url_website') ? $errors->first('url_website') : "url website" . ($user->organisation->url_website ? ": " . $user->organisation->url_website : "")}}" value="{{ $user->organisation->url_website ? $user->organisation->url_website : ""}}">
            <div id="hiddengegevens">
                <input type="hidden" name="hidden_adres" id="hidden_adres">
                <input type="hidden" name="hidden_stad" id="hidden_stad">
                <input type="hidden" name="hidden_url_locatie" id="hidden_url_locatie">
                <input type="hidden" name="hidden_url_website" id="hidden_url_website">
            </div>
            <input type="submit" value="gegevens opslaan">
        </form>
    </section>
    @endorganisatie
    @auth
    <section id="account-shmeh">
        <h3>account-shmeh</h3>
        <form action="wijzignaam#wijzigen-naam" method="post" id="wijzigen-naam">
            @csrf
            <input type="text" name="naam" id="naam" required placeholder='{{ $errors->has('naam') ? $errors->first('naam') : 'naam: '. $user->name }}'>
            <input type="submit" value="wijzigen">
        </form>
        <form action="wijzigwachtwoord#wijzigen-wachtwoord" method="post" id="wijzigen-wachtwoord">
            @csrf
            <input type="password" name="wachtwoord-oud" id="wachtwoord-oud" placeholder="{{ $errors->has('wachtwoord-oud') ? $errors->first('wachtwoord-oud') : "huidig wachtwoord"}}" required>
            <input type="password" name="wachtwoord" id="wachtwoord" placeholder="{{ $errors->has('wachtwoord') ? $errors->first('wachtwoord') : "nieuw wachtwoord"}}" required>
            <input type="password" name="wachtwoord2" id="wachtwoord2" placeholder="nieuw wachtwoord herhalen" required>
            <input type="submit" value="wijzigen">
        </form>
        {{-- <form action="wijzigemail" method="post" id="wijzigen-naam">
            @csrf
            <input type="email" name="email" id="email" placeholder="email adres" @if ($user->email) value="{{$user->email}}" @endif>
            <input type="submit" value="wijzigen">
        </form>         --}}
        @gebruiker
        <form action="devicelink#devicelink" method="post" id="devicelink">
            @csrf
            <p>Laat toe dat dit toestel ook zonder in te loggen aan jouw opgeslagen evenementen kan enzo. Er kan maar één account per device gelinkt worden natuurlijk... </p>
            <p>{{ request()->cookie('device_id') === $user->guest->device_id ? 'Jouw account is gelinkt.' : 'Jouw account is niet gelinkt.' }} </p>
            <input type="submit" value="{{ request()->cookie('device_id') === $user->guest->device_id ? 'ontlinken' : 'linken' }}">
        </form>
        @endgebruiker
        <form action="verwijder" method="post" id="account-verwijderen">
            @csrf
            @method('DELETE')
            <label for="verwijder-account"><input type="checkbox" name="verwijder-account" id="verwijder-account">ik wil</label>
            <label for="verwijder-zeker"><input type="checkbox" name="verwijder-zeker" id="verwijder-zeker">dit account</label>
            <input type="submit" value="verwijderen">
        </form>
        <form action="logout" method="post" id='uitloggen'>
            @csrf
            <button>uitloggen</button>
        </form>
    </section>
    @endif
</main>    
@endsection


@section('script')
<script>

    let standaardgegevensForm = document.querySelector('#standaard-gegevens form');
    let submit = document.querySelectorAll('#standaard-gegevens input[type="submit"]');

    let osm = document.querySelector('#openstreetmap');

    let waarde = [];
    let placeholders = [];
    let hiddenGegevens = document.querySelectorAll('#hiddengegevens input');

    document.addEventListener("DOMContentLoaded", (event) => {
        let velden = document.querySelectorAll('#standaard-gegevens input[type="text"]');
        for (let i = 0; i < velden.length; i++) {
            waarde[i] = velden[i].value;
            placeholders[i] = velden[i].placeholder;
            velden[i].placeholder = placeholders[i];
            velden[i].value = "";
        }

        if (waarde[2].length > 0) {
            osm.style.display='none';
        } else {
            osm.style.display='block'
        }

        // console.log(waarde);
        for (let i = 0; i < velden.length; i++) {
            velden[i].addEventListener('click', (e) => {
                    velden[i].value = waarde[i];
                });
                
            velden[i].addEventListener('input', (e) => {
                waarde[i] = velden[i].value
                velden[i].placeholder = "";
                if (waarde[2].length > 0) {
                    osm.style.display='none';
                } else {
                    osm.style.display='block'
                }
            })

        };

        standaardgegevensForm.addEventListener('submit', (e) => {
        e.preventDefault();
        
        for (let i = 0; i < velden.length; i++) {
            hiddenGegevens[i].value = waarde[i];
            
        }
        standaardgegevensForm.submit()
        })

    })

    const gebruikerKnop = document.querySelector('.switcher div');
    const gebruikerForm = document.querySelector('form#maak-gebruiker');
    const organisatieKnop = document.querySelector('.switcher div:last-of-type');
    const organisatieForm = document.querySelector('form#maak-organisatie');

    const organisatieSubmit = organisatieForm.querySelector('input[type="submit"]')
    
    document.addEventListener('DOMContentLoaded', (e) => {
        let formTab;
        if (localStorage.getItem('formTab')) {
            formTab = localStorage.getItem('formTab');
            localStorage.setItem('formTab', 'gebruiker')
        } else {
            formTab = 'gebruiker';
        }
        doeMaar(formTab);
    })

    organisatieSubmit.addEventListener('click', (e) => {
        localStorage.setItem('formTab', 'organisatie');
    })

    gebruikerKnop.addEventListener('click', (e) => {
        let formTab = 'gebruiker';
        // localStorage.setItem('formTab', 'gebruiker');
        doeMaar(formTab);
    })

    organisatieKnop.addEventListener('click', (e) => {
        let formTab = 'organisatie';
        // localStorage.setItem('formTab', 'organisatie');
        doeMaar(formTab);
    })

    function doeMaar(formTab) {
        if (formTab === 'gebruiker') {
            organisatieKnop.classList.remove('actief');
            organisatieForm.classList.remove('actief');
            gebruikerKnop.classList.add('actief');
            gebruikerForm.classList.add('actief');
        } else {
            gebruikerKnop.classList.remove('actief');
            gebruikerForm.classList.remove('actief');
            organisatieKnop.classList.add('actief');
            organisatieForm.classList.add('actief');
        }
    }

</script>
@endsection