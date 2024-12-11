<a href="{{ route('thuis') }}" class="{{ request()->routeIs('thuis') ? 'actief' : '' }}">catalogus</a> 
@organisatie
<a href="{{ route('overzicht-organisatie') }}" class="{{ request()->routeIs('overzicht-organisatie') ? 'actief' : '' }}">eigen ({{$userEvents}})</a>
@else
<a href="{{ route('overzicht-gebruiker') }}" class="{{ request()->routeIs('overzicht-gebruiker') ? 'actief' : '' }}">bewaard ({{$userEvents}})</a>
@endif
<a href="{{ route('aanmaken') }}" class="{{ request()->routeIs('aanmelden')? 'actief' : '' }}">toevoegen</a>

{{-- @auth<a href="{{ route('aanmaken') }}" class="{{ request()->routeIs('aanmaken') ? 'actief' : '' }}">evenement aanmaken</a>@endauth --}}
