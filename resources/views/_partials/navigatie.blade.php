<a href="{{ route('thuis') }}" class="{{ request()->routeIs('thuis') ? 'actief' : '' }}">alles</a>
@organisatie
<a href="{{ route('overzicht-organisatie') }}" class="{{ request()->routeIs('overzicht-organisatie') ? 'actief' : '' }}">overzicht</a>
@else
<a href="{{ route('overzicht-gebruiker') }}" class="{{ request()->routeIs('overzicht-gebruiker') ? 'actief' : '' }}">overzicht</a>
@endif

@auth 
<a href="{{ route('aanmaken') }}" class="{{ request()->routeIs('aanmaken') ? 'actief' : '' }}">toevoegen</a>
@else
<a href="{{ route('aanmelden') }}" class="{{ request()->routeIs('aanmelden') ? 'actief' : '' }}">aanmelden</a> 
@endauth
{{-- @auth<a href="{{ route('aanmaken') }}" class="{{ request()->routeIs('aanmaken') ? 'actief' : '' }}">evenement aanmaken</a>@endauth --}}
