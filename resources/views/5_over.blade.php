@extends('_layouts.head')

@section('head')
@include('_partials.metadata')
<script src="{{ asset('js/kopieren.js') }}" defer></script>
@endsection


@section('title', 'overzicht')

@section('main')
<main>
    <section>
        <h3>over dit project</h3>
        <p>Deze website is ontstaan uit een grote afkeer voor de gigant meta, en daarnaast uit faceboeks enige handige functie: evenementen. Ik hoop stiekem zo een beetje dat deze website voor sommigen de stap van sociale media kan vergemakkelijken.</p> 
        <p>Ik zou het super hard apprecieëren als je jouw bedenkingen, of bepaalde suggesties ofzo, over deze website wilt delen met mij. Alle soort feedback is welkom :)</p>
        <p onclick="copy('gustave.curtil@tutanota.com', 'mail')"><u>gustave.curtil@tutanota.com</u></p>
    </section>
    <section>
        <h3>mededeling</h3>
        <p>Registreren en inloggen als gebruiker heeft op dit moment nog niet echt een functie (buiten dat je bewaarde evenementen op een ander toestel kan overzetten/bekijken). Als organisatie kan je wel al een account maken om evenementen toe te voegen.</p>
        <p>Rond Februari 2025 komt er een update waardoor je ook besloten evenementen kan maken.</p>
    </section>
    <section>
        <h3>voeg deze website toe als app</h3>
        <p>Dit is een Progressive Web App (PWA), waardoor deze website kan worden geinstalleerd als een applicatie op de meeste toestellen. Hier zijn de instructies:</p>
        <h4>android</h4>
        <p>1. Druk op het menu icoon (3 bolletjes bovenaan rechts) en druk op 'add to home screen'.</p>
        <p>2. Je zal dan de optie krijgen een naam in te vullen voor de shortcut en chrome zal de app toevoegen aan uw scherm.</p>
        <h4>apple toestellen</h4>
        <p>1. Druk op de 'deel' knop (de vierkant met een pijl die er langs boven uitkomt) onderaan het scherm.</p>
        <p>2. Scroll naar beneden de lijst an druk op 'add to home screen'.</p>
        <p>3. Je zal dan de optie krijgen een naam in te vullen voor de shortcut en safari zal de app toevoegen aan uw scherm.</p>
    </section>
</main>
@endsection
