<a href="{{ route('thuis') }}" class="{{ request()->routeIs('thuis') ? 'actief' : '' }}">catalogus</a>
<a href="{{ route('aanmaken') }}" class="{{ request()->routeIs('aanmelden')? 'actief' : '' }}">toevoegen</a> 
@organisatie
<a href="{{ route('overzicht-organisatie') }}" class="{{ request()->routeIs('overzicht-organisatie') ? 'actief' : '' }}">aangemaakt ({{$userEvents}})</a>
@else
<a href="{{ route('overzicht-gebruiker') }}" class="{{ request()->routeIs('overzicht-gebruiker') ? 'actief' : '' }}">bewaard ({{$userEvents}})</a>
@endif

{{-- @auth<a href="{{ route('aanmaken') }}" class="{{ request()->routeIs('aanmaken') ? 'actief' : '' }}">evenement aanmaken</a>@endauth --}}
