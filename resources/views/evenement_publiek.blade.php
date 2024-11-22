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
        <div class='bedieningspaneel'>
            @organisatie
            <button>evenement aanpassen</button>
            @else
            <form action="/opslaan/{{$event->id}}" method="POST">
                @csrf
                <button type='subtmit' id="opslaan" @if ($user->savedPublicEvents->contains($event->id)) class='actief' @endif>
                    @if ($user->savedPublicEvents->contains($event->id))
                    opgeslaan
                    @else 
                    opslaan
                    @endif
                </button>
            </form>
            <!-- <button>kalender koppelen</button> -->
            @endorganisatie
            <button>link kopiëren</button>
        </div>
    </section>
    <section>
        {!! nl2br(e($event->beschrijving)) !!}
    </section>
</main>
@endsection

@section('script')
<script>

</script>
@endsection