@extends('_layouts.head')

@section('head')
<script src="{{asset('js/filters.js')}}" defer></script>
@endsection

@section('title', 'overzicht')

@section('main')
<main>
    @if ($userEvents === 0)
    <section>
        Er zijn momenteel geen bewaarde evenementen.
    </section>
    @else
    <section class="evenementen">
        @foreach ($events as $event)
        <div class="evenement" data-stad="{{ $event->stad }}" data-categorie="{{ $event->categorie }}"  onclick="gaNaar('{{ url('/' . $event->id . '-' . \Str::slug($event->titel)) }}', event)" >
            <figure style="background-color: {{$event->kleur}};">
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
                    <div>{{$event->categorie}}</div>
                </div>
                <div class="locatie">
                    <div>{{$event->user->name}}</div>
                    <div><span>{{$event->stad}}</span></div>
                </div>
            </div>
        </div>
        @endforeach
        <div id="laatst-bijgewerkt"></div>
    </section>
    @endif
    {{-- <section>
        <p>overzicht van opgeslagen evenementen, uitnodigingen en zelf gemaakte evenementen</p>
        <p>nog aan het twijfelen om organisaties te kunnen volgen; zoja, komen die ook hier te staan</p>
    </section> --}}
    {{-- <section class="evenementen">
        @for ($i = 0; $i < 3; $i++)
        <div class="evenement" onclick="window.location.href='{{ url('/id-event-titel') }}'">
            <figure></figure>
            <div>
                <div class="titel">uitnodiging{{$i + 1}} [hardcoded tekst]</div>
                <div class="datum">
                    <div>di 05/11/2024 - 04u20</div>
                    <div></div>
                </div>
                <div class="locatie">
                    <div>Marco Polo</div>
                    <div><span>⌂</span></div>
                </div>
            </div>
        </div>
        @endfor
        @foreach ($events as $event)
        <div class="evenement" data-stad="{{ $event->stad }}" data-categorie="{{ $event->categorie }}"  onclick="gaNaar('{{url('/id-event-titel') }}', event)" >
            <figure style="background-color: {{$event->kleur}};"></figure>
            <div>
                <div class="titel">{{$event->titel}}</div>
                <div class="datum">
                    <div>{{$event->datum}} - {{$event->tijd}}</div>
                    <div>{{$event->categorie}}</div>
                </div>
                <div class="locatie">
                    <div>{{$event->user->name}}</div>
                    <div><span>{{$event->stad}}</span></div>
                </div>
            </div>
        </div>
        @endforeach
    </section> --}}
</main>

@endsection