@extends('_layouts.head')

@section('title', $event->titel)

@section('main')
<main>
    <figure class="poster" style="background-color: {{$event->kleur}};">
        @if (!empty($event->foto_pad))
        <img src="/storage/posters/{{ $event->foto_pad }}" alt="poster voor het evenement: {{ $event->titel }}" loading="lazy" 
             style="left: {{ $event->horizontaal }}%; top: {{ $event->verticaal }}%; 
             transform: translate(-50%, -50%) scale({{ $event->zoom }}%);">
         @endif  
    </figure>
    <section>
        <h3>{{$event->titel}}</h3>
        <p>{{$event->datum}} om {{$event->tijd}}</p>
        <p><u>{{$event->user->name}}</u> - <u><i>{{$event->adres}}, {{$event->stad}}</i></u></p>
        @organisatie
        <button>evenement aanpassen</button>
        @else
        <button id="opslaan">opslaan</button><button>kalender koppelen</button>
        @endorganisatie
        <button>link kopieëren</button>
    </section>
    <section>
        {!! nl2br(e($event->beschrijving)) !!}
    </section>
</main>
@endsection

@section('script')
<script>
    let volgKnop = document.querySelector('#volgen')
    let opslaanKnop = document.querySelector('#opslaan')

    if(volgKnop) {
        volgKnop.addEventListener('click', () => {
            if (volgKnop.classList.contains('actief')) { // Use contains instead of has
                volgKnop.classList.remove('actief');
                volgKnop.innerHTML = 'volgen';
            } else {
                volgKnop.classList.add('actief');
                volgKnop.innerHTML = 'volgend'; // Optional: set text when active
            }
        });
    }

    if (opslaanKnop) {
        opslaanKnop.addEventListener('click', () => {
        if (opslaanKnop.classList.contains('actief')) { // Use contains instead of has
            opslaanKnop.classList.remove('actief');
            opslaanKnop.innerHTML = 'opslaan';
        } else {
            opslaanKnop.classList.add('actief');
            opslaanKnop.innerHTML = 'opgeslaan'; // Optional: set text when active
        }
    });
    }
</script>
@endsection