<figure class="poster" style="background-color: {{$event->kleur}}; background-image: url(./media/achtergronden/{{$event->achtergrond_pad}})">
    @if (!empty($event->foto_pad))
    <img src="/storage/miniaturen/{{ $event->foto_pad }}" alt="poster voor het evenement: {{ $event->titel }}" loading="lazy" 
            style="left: {{ $event->horizontaal }}%; top: {{ $event->verticaal }}%; 
            transform: translate(-50%, -50%) scale({{ $event->zoom }}%);">
        @endif  
</figure>
<div>
    <div class="datum">
        <div><span>{{$event->dag}} {{$event->datum}}</span><span> om {{$event->tijd}}</span></div>
        <div>{{$event->user->name}}</div>
    </div>
    <div class="titel">
        <span>{{$event->titel}}</span>
    </div>
    <div class="labels">
        <div class="label">
            {{ $event->categorie }}
            @if ($event->subcategorie)
                <span>&nbsp;| {{ $event->subcategorie }}</span>
            @endif
        </div>
        <div class="label">{{$event->stad}}</div>
    </div>
    @organisatie
    <div class="statistieken">
        <div class="label">{{$event->categorie }}{{ $event->subcategorie ? " |" . $event->subcategorie : '' }}</div>
        <div>
            @if ($user->publicEvents->contains($event->id))
                bewaard: {{$event->savedByGuests->count()}}
            @endif
        </div>
    </div>
    @endorganisatie
</div>