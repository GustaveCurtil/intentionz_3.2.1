<a href="{{ route('thuis') }}" class="{{ request()->routeIs('thuis') ? 'actief' : '' }}">alles</a>
@organisatie
<a href="{{ route('overzicht-organisatie') }}" class="{{ request()->routeIs('overzicht-organisatie') ? 'actief' : '' }}">overzicht</a>
@else
<a href="{{ route('overzicht-gebruiker') }}" class="{{ request()->routeIs('overzicht-gebruiker') ? 'actief' : '' }}">overzicht ({{$userEvents}})</a>
@endif

<a href="{{ route('instellingen') }}" class="{{ request()->routeIs('instellingen') ? 'actief' : '' }}">profiel</a> 

{{-- @auth<a href="{{ route('aanmaken') }}" class="{{ request()->routeIs('aanmaken') ? 'actief' : '' }}">evenement aanmaken</a>@endauth --}}
