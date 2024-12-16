<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, viewport-fit=cover">
  
    <meta name="theme-color" id="theme-color" content="#cedbcf">

    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:locale" content="nl_BE" />

    @yield('head')

    {{-- title should be unique on every page... --}}
    <title>@yield('title')</title> 
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <script src="{{ asset('js/loadingtime.js') }}" defer></script>

</head>
<style>
    :root {
        --kleur-achtergrond: {{ $guest->kleur_achtergrond ?? $user->organisation->kleur_achtergrond ?? '#cedbcf' }};
        --kleur-thema: {{ $guest->kleur_thema ?? $user->organisation->kleur_thema ?? '#f5aeb7' }};
        --kleur-thema2: {{ $guest->kleur_thema2 ?? $user->organisation->kleur_thema2 ?? '#cac9e8' }};
        --kleur-thema3: {{ $guest->kleur_thema3 ?? $user->organisation->kleur_thema3 ?? '#f5f5dc' }};
        --kleur-tekst: {{ $guest->kleur_tekst ?? $user->organisation->kleur_tekst ?? '#4b4b4b' }};
    }
</style>
<body>
    <header>
        <div>
            @hasSection('terugknop')
                @yield('terugknop')
            @else
                <a href="{{ route('over') }}" class="{{ request()->routeIs('over') ? 'actief' : '' }}">over</a>
            @endif
        </div>
        @if(!request()->routeIs('aanmaken'))
        <div id="datum">wo 10 dec</div>
        <div>
            <a href="{{ route('instellingen') }}" class="{{ request()->routeIs('instellingen') ? 'actief' : '' }}">
                @if ($user)
                <span>{{$user->name}}</span>
                @else
                instellingen
                @endif
            </a>
        </div>
        @endif
    </header>
    
    @yield('main')

    @if(!request()->routeIs('aanmaken') && !request()->routeIs('aanpassen'))
    <nav>@include('_partials.navigatie')</nav>
    @endif

    @yield('script')
    <script>
        // VOOR DE TERUGKNOP MOET ELKE KEER DE HUIDIGE PAGINA BIJGEHOUDEN WORDEN
        let actieveURL = window.location.href;
        let huidigeURL = localStorage.getItem('huidigeURL')
        let vorigeURL = localStorage.getItem('vorigeURL')
        let oudsteURL = localStorage.getItem('oudsteURL')

        if (actieveURL !== huidigeURL) {
            if (actieveURL !== vorigeURL) {
                localStorage.setItem('huidigeURL', actieveURL);
                localStorage.setItem('vorigeURL', huidigeURL);
                localStorage.setItem('oudsteURL', vorigeURL);
            } else {
                localStorage.setItem('huidigeURL', actieveURL);
                localStorage.setItem('vorigeURL', oudsteURL);
            }
        } 

        //VOOR DIE APPLIFICATIE VAN DE WEBSITE jwz
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register("{{ asset('service-worker.js') }}")
            .then(reg => console.log('Service Worker registered!', reg))
            .catch(err => console.error('Service Worker registration failed:', err));
        }

        const themeColor = getComputedStyle(document.documentElement).getPropertyValue('--kleur-achtergrond').trim();
        document.getElementById('theme-color').setAttribute('content', themeColor);
    </script>
</body>
