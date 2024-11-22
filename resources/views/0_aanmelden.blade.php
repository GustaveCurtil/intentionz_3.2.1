@extends('_layouts.head')

@section('title', 'aanmelden')

@section('main')
<main>
    <section>
        <h3>inloggen</h3>
        <form action="login" method="post" autocomplete="off">
            @csrf
            <input type="text" name="naam" id="naam" placeholder="{{ $errors->has('login_naam') ? $errors->first('login_naam') : 'gebruikersnaam*' }}" value="{{ $errors->has('login_wachtwoord') ? old('naam') : "" }}">
            <input type="password" name="wachtwoord" id="wachtwoord" placeholder="{{ $errors->has('login_wachtwoord') ? $errors->first('login_wachtwoord') : 'wachtwoord*' }}" required>
            <input type="submit" value="inloggen">
        </form>
    </section>
    <section>
        <h3>registreren</h3>
        <div class="switcher">
            <div class="actief">als gebruiker</div>
            <div>als organisatie</div>
        </div>
        <form action="maak-gebruiker" method="post" autocomplete="off" class='actief' id="maak-gebruiker">
            @csrf
            <input type="text" name="gebruiker_naam" id="gebruiker_naam" required placeholder="{{ $errors->has('gebruiker_naam') ? $errors->first('gebruiker_naam') : 'gebruikersnaam*'}}" value="{{ $errors->has('gebruiker_naam') ? "" : old('gebruiker_naam')}}">
            <input type="password" name="gebruiker_wachtwoord" id="gebruiker_wachtwoord" placeholder="{{ $errors->has('gebruiker_wachtwoord') ? $errors->first('gebruiker_wachtwoord') : 'wachtwoord*'}}" required>
            <input type="password" name="gebruiker_wachtwoord2" id="gebruiker_wachtwoord2" placeholder="{{ $errors->has('gebruiker_wachtwoord2') ? $errors->first('gebruiker_wachtwoord2') : 'wachtwoord herhalen*'}}" required>
            <input type="hidden" name="gebruiker_email" id="gebruiker_email" placeholder="e-mail (voor als je het wachtwoord vergeten bent)" @if ($errors->any()) value="{{ old('email') }}" @endif>
            <input type="submit" value="account gebruiker aanmaken">
        </form>
        <form action="maak-organisatie" method="post" autocomplete="off" id="maak-organisatie">
            @csrf
            <input type="text" name="organisatie_naam" id="organisatie_naam" placeholder="{{ $errors->has('oranisatie_naam') ? $errors->first('oranisatie_naam') : 'naam organisatie*'}}" value="{{ $errors->has('organisatie_naam') ? "" : old('organisatie_naam')}}">
            <input type="password" name="organisatie_wachtwoord" id="organisatie_wachtwoord" placeholder="{{ $errors->has('organisatie_wachtwoord') ? $errors->first('organisatie_wachtwoord') : 'wachtwoord*'}}">
            <input type="password" name="organisatie_wachtwoord2" id="organisatie_wachtwoord2" placeholder="{{ $errors->has('organisatie_wachtwoord2') ? $errors->first('organisatie_wachtwoord2') : 'wachtwoord herhalen*'}}">
            <input type="hidden" name="organisatie_email" id="organisatie_email" placeholder="e-mail (optioneel)">
            <div class="adres">
                <input type="text" name="organisatie_adres" id="organisatie_adres" placeholder="straat en nummer (optioneel)" value="{{old('organisatie_adres')}}">
                <input type="text" name="organisatie_stad" id="organisatie_stad" placeholder="stad (optioneel)" value="{{old('organisatie_stad')}}">    
                <input type="url" name="organisatie_url_locatie" id="organisatie_url_locatie" placeholder="map link (optioneel)" value="{{old('organisatie_url_locatie')}}">
                <div onclick="window.open('https://www.openstreetmap.org', '_blank')">openstreetmap.org</div>
            </div>
            <input type="url" name="organisatie_url_website" id="organisatie_url_website" placeholder="website (optioneel)" value="{{old('organisatie_url_website')}}">
            <input type="submit" value="account organisatie aanmaken">
        </form> 
    </section>
    <section>
        <p>Registreren en inloggen als gebruiker heeft op dit moment nog geen functie (buiten dat je dan je opgeslagen evenementen ook op een ander toestel kunt bekijken), maar rond Februari 2025 komt er een update waardoor je ook gesloten evenementen kan maken. :)</p>
    </section>
</main>
@endsection

@section('script')
<script>
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