@extends('_layouts.head')

@section('title', 'overzicht')

@section('main')
<main>
    <section>
        <p>Overzicht van de evenementen die deze organisatie heeft aangemaakt.</p>
        <p>Organisatie kan zien hoeveel mensen een evenement hebben opgeslaan</p>
    </section>
    {{-- <section class="evenementen">
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
                    <div>{{$user->name}}</div>
                    <div><span>{{$user->organisation->stad}}</span></div>
                </div>
            </div>
        </div>
        @endforeach
    </section> --}}
 
</main>
@endsection