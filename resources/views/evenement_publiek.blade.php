@extends('_layouts.head')

@section('head')
<meta property="og:title" content="{{$event->titel}}" />
<meta property="og:description" content="{{ Str::limit(strip_tags($event->beschrijving), 200) }}" />
<meta property="og:image" content="{{ asset('storage/miniaturen/' . $event->foto_pad ) }}" />
<script src="{{ asset('js/terugknop.js') }}" defer></script>
<script src="{{ asset('js/kopieren.js') }}" defer></script>
@endsection

@section('terugknop')
<a id="terugknop" href="/">terug</a>
@endsection

@section('title', $event->titel)

@section('main')
<main>
    <figure class="poster" style="background-color: {{$event->kleur}}; background-image: url(./media/achtergronden/{{$event->achtergrond_pad}})">
        @if (!empty($event->foto_pad))
        <img src="/storage/posters/{{ $event->foto_pad }}" alt="poster voor het evenement: {{ $event->titel }}" loading="lazy" 
             style="left: {{ $event->horizontaal }}%; top: {{ $event->verticaal }}%; 
             transform: translate(-50%, -50%) scale({{ $event->zoom }}%);">
         @endif  
    </figure>
    <section>
        <h3>{{$event->titel}}</h3>
        <p>{{$event->datum}} om {{$event->tijd}}</p>
        <p>{{$event->user->name}} - <u onclick="copy('{{ $event->adres }}, {{ $event->stad }}', 'adres')"><i>{{ $event->adres }}, {{ $event->stad }}</i></u></p>
        <div class='bedieningspaneel'>
            @organisatie
                @if ($user->publicEvents->contains($event->id))
                <button onclick="window.location.href = '{{ route('aanpassen', $event->id) }}';">evenement aanpassen</button>
                @endif
            @endorganisatie
            @if ($guest)
            <form action="/opslaan/{{$event->id}}" method="POST">
                @csrf
                <button type='subtmit' id="opslaan" @if ($guest->savedPublicEvents->contains($event->id)) class='actief' @endif>
                    @if ($guest->savedPublicEvents->contains($event->id))
                    bewaard
                    @else 
                    bewaren
                    @endif
                </button>
            </form>
            <!-- <button>kalender koppelen</button> -->
            @endif
            <button onclick="copy(window.location.href, 'link naar dit evenement')">link kopiëren</button>
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