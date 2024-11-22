<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, viewport-fit=cover">
    <meta name="description" content="Form follows CSS follows JS follows HTML follows PHP follows Function">
    <meta name="theme-color" id="theme-color" content="#cedbcf">

    {{-- title should be unique on every page... --}}
    <title>♥ @yield('title')</title> 
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <script src="{{ asset('js/loadingtime.js') }}" defer></script>
    @yield('head')
</head>
<style>
    :root {
        --kleur-achtergrond: {{ $user->guest->kleur_achtergrond ?? $user->organisation->kleur_achtergrond ?? $user->kleur_achtergrond ?? '#cedbcf' }};
        --kleur-thema: {{ $user->guest->kleur_thema ?? $user->organisation->kleur_thema ?? $user->kleur_thema ?? '#f5aeb7' }};
        --kleur-thema2: {{ $user->guest->kleur_thema2 ?? $user->organisation->kleur_thema2 ?? $user->kleur_thema2 ?? '#cac9e8' }};
        --kleur-thema3: {{ $user->guest->kleur_thema3 ?? $user->organisation->kleur_thema3 ?? $user->kleur_thema3 ?? '#f5f5dc' }};
        --kleur-tekst: {{ $user->guest->kleur_tekst ?? $user->organisation->kleur_tekst ?? $user->kleur_tekst ?? '#4b4b4b' }};
    }
</style>
<body>
    <header>
    @sectionMissing('header')
            <div><a href="{{ route('zen') }}" class="{{ request()->routeIs('zen') ? 'actief' : '' }}"><span id='loading'>even laden<span></span></span><span id="time"></span></a></div>
            <div><a href="{{ route('over') }}"><img src="{{ asset('favicon.ico') }}" alt="Favicon"></a></div>
            <div><a href="{{ route('instellingen') }}" class="{{ request()->routeIs('instellingen') ? 'actief' : '' }}">@auth {{$user->name}} @else instellingen @endauth</a></div>
    @else
        @yield('header')
    @endif
    </header>
    
    @yield('main')

    <nav>@include('_partials.navigatie')</nav>
    @yield('script')
    <script>

        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register("{{ asset('service-worker.js') }}")
            .then(reg => console.log('Service Worker registered!', reg))
            .catch(err => console.error('Service Worker registration failed:', err));
        }

        const themeColor = getComputedStyle(document.documentElement).getPropertyValue('--kleur-achtergrond').trim();
        document.getElementById('theme-color').setAttribute('content', themeColor);
    </script>
</body>
