@extends('_layouts.head')

@section('head')
<script src="{{ asset('js/terugknop.js') }}" defer></script>
<script src="{{ asset('js/kopieren.js') }}" defer></script>
@endsection

@section('terugknop')
<a id="terugknop" href="/">terug</a>
@endsection


@section('title', 'overzicht')

@section('main')
<main>
    <section>
        <h3>over dit project</h3>
        <p>Deze website is ontstaan uit een grote afkeer voor de gigant meta, en daarnaast uit faceboeks enige handige functie: evenementen. Ik hoop dat deze website voor sommigen de stap van facebook kan vergemakkelijken. Ik heb lekker veel plezier aan het maken van dit platform. En uhm... ik zou het super hard apprecieëren als je jouw bedenkingen over deze website wilt delen met mij. Alle soort feedback is welkom :)</p>
        <p onclick="copy('gustave.curtil@tutanota.com', 'mail')"><u>gustave.curtil@tutanota.com</u></p>
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
