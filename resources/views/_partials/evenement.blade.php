
<figure class="poster" style="background-color: {{$event->kleur}}; background-image: url(./media/achtergronden/{{$event->achtergrond_pad}})">
    @if (!empty($event->foto_pad))
    <img src="/storage/miniaturen/{{ $event->foto_pad }}" alt="poster voor het evenement: {{ $event->titel }}" loading="lazy" 
            style="left: {{ $event->horizontaal }}%; top: {{ $event->verticaal }}%; 
            transform: translate(-50%, -50%) scale({{ $event->zoom }}%);">
        @endif  
</figure>
<div>
    <div class="titel">{{$event->titel}}</div>
    <div class="datum">
        <div>{{$event->datum}} - {{$event->tijd}}</div>
        <div class="label">{{ $event->subcategorie ? "(" . $event->subcategorie . ") " : '' }}{{$event->categorie }}</div>
    </div>
    <div class="locatie">
        <div>{{$event->user->name}}</div>
        <div class="label">{{$event->stad}}</div>
    </div>
    @organisatie
    <div class="statistieken">
        <div>
            @if ($user->publicEvents->contains($event->id))
                bewaard: {{$event->savedByGuests->count()}}
            @endif
        </div>
        <div class="label">{{$event->stad}}</div>
    </div>
    @endorganisatie
</div>