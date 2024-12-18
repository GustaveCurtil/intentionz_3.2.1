@extends('_layouts.head')

@section('title', 'Catalogus')

@section('head')
@include('_partials.metadata')
<script src="{{asset('js/nieuw.js')}}" defer></script>
<script src="{{asset('js/nieuw2.1.js')}}" defer></script>
<script src="{{asset('js/nieuw2.2.js')}}" defer></script>
<script src="{{asset('js/nieuw3.js')}}" defer></script>
<script src="{{asset('js/nieuw4.js')}}" defer></script>
@endsection

@section('main')
<main>
<section class="evenementen">

    <div class="week">
        <div>alle evenementen</div>
        @if ($events->isNotEmpty())
        @foreach ($events as $event)
        <div class="evenement" data-locatie="{{ $event->stad }}" data-categorie="{{ $event->categorie }}" data-label="{{ $event->subcategorie }}"  data-datum="{{ $event->datum }}" onclick="gaNaar('{{ url('/' . $event->id . '-' . \Str::slug($event->titel)) }}', event)" >
            @include('_partials.evenement')
        </div>
        @endforeach
        @endif
    </div>
    <div id="laatst-bijgewerkt"></div>
</section>

<div class="commandos">
    <div class="filter" id="locatie"></div>
    <div class="filter" id="categorie"></div>
    <div class="filter" id="label"></div>
    <div class="filter" id="periode">
        <table>
            <tr>
                <td><div><span>ma</span><span></span><span></span></div></td>
                <td><div><span>di</span><span></span><span></span></div></td>
                <td><div><span>wo</span><span></span><span></span></div></td>
                <td><div><span>do</span><span></span><span></span></div></td>
                <td><div><span>vr</span><span></span><span></span></div></td>
                <td><div><span>za</span><span></span><span></span></div></td>
                <td><div><span>zo</span><span></span><span></span></div></td>
            </tr>
            <tr>
                <td><div><span>ma</span><span></span><span></span></div></td>
                <td><div><span>di</span><span></span><span></span></div></td>
                <td><div><span>wo</span><span></span><span></span></div></td>
                <td><div><span>do</span><span></span><span></span></div></td>
                <td><div><span>vr</span><span></span><span></span></div></td>
                <td><div><span>za</span><span></span><span></span></div></td>
                <td><div><span>zo</span><span></span><span></span></div></td>
            </tr>
            <tr>
                <td><div><span>ma</span><span></span><span></span></div></td>
                <td><div><span>di</span><span></span><span></span></div></td>
                <td><div><span>wo</span><span></span><span></span></div></td>
                <td><div><span>do</span><span></span><span></span></div></td>
                <td><div><span>vr</span><span></span><span></span></div></td>
                <td><div><span>za</span><span></span><span></span></div></td>
                <td><div><span>zo</span><span></span><span></span></div></td>
            </tr>
        </table>
    </div>

    <div id="filters">
        <div>
            <button data-filter='locatie'><span>locatie:</span><span>overal</span></button>
            <button data-filter='periode'><span>periode:</span><span>🏗️ 🛠️</span></button>
        </div>
        <div>
            <button data-filter='categorie'><span>categorie:</span><span>alles</span></button>
            <button data-filter='label'><span>label:</span><span>alles</span></button>
        </div>
    </div>
</div>
{{-- <section class="evenementen">

    <div class="week">
        <div>deze week</div>
        @if ($eventsDezeWeek->isNotEmpty())
        @foreach ($eventsDezeWeek as $event)
        <div class="evenement" data-stad="{{ $event->stad }}" data-categorie="{{ $event->categorie }}"  onclick="gaNaar('{{ url('/' . $event->id . '-' . \Str::slug($event->titel)) }}', event)" >
            @include('_partials.evenement')
        </div>
        @endforeach
        @endif
    </div>

    <div class="week">
        <div>volgende week</div>
        @if ($eventsVolgendeWeek->isNotEmpty())
        @foreach ($eventsVolgendeWeek as $event)
        <div class="evenement" data-stad="{{ $event->stad }}" data-categorie="{{ $event->categorie }}"  onclick="gaNaar('{{ url('/' . $event->id . '-' . \Str::slug($event->titel)) }}', event)" >
            @include('_partials.evenement')
        </div>
        @endforeach
        @endif
    </div>

    <div class="week">
        <div>verder</div>
        @if ($eventsVerder->isNotEmpty())
        @foreach ($eventsVerder as $event)
        <div class="evenement" data-stad="{{ $event->stad }}" data-categorie="{{ $event->categorie }}"  onclick="gaNaar('{{ url('/' . $event->id . '-' . \Str::slug($event->titel)) }}', event)" >
            @include('_partials.evenement')
        </div>
        @endforeach
        @endif
    </div>
    <div id="laatst-bijgewerkt"></div>
</section>

<div class="commandos">
    <div class="wat" data-stad="overal">
        <button id="alles" data-soort='categorie' class="rond">alles</button>
        @foreach ($categoriesAll as $categorie)
        <button data-soort='categorie'>{{$categorie}}</button>
        @endforeach
    </div>
    @foreach ($steden as $stad => $categories)
    <div class="wat" data-stad="{{$stad}}">
        <button id="alles" data-soort='categorie' class="rond">alles</button>
        @foreach ($categories as $categorie)
        <button data-soort='categorie'>{{$categorie}}</button>
        @endforeach
    </div>
    @endforeach
    <div id="waar">
        <button id="alles" data-soort='locatie' class="rond">overal</button>
        @foreach ($steden as $stad => $categories)
            <button data-soort='locatie'>{{$stad}}</button>
        @endforeach
    </div>
    <div id="filters">
        <div>
            <button data-filter='locatie'><span>locatie:</span><span>overal</span></button>
            <button data-filter='categorie'><span>categorie:</span><span>alles</span></button>
        </div>
        <div>
            <button data-filter='periode'>periode</button>
            <button data-filter='label'><span>label:</span><span>allesbehalvemanennogveellangr</span></button>
        </div>
        <button class="rond">subcategorie</button>
        <button class="rond">periode</button>
    </div>
</div> --}}
</main>
<script>
    const evenementenData = @json($events);
    let evenementen = document.querySelectorAll('div.evenement')
</script>
@endsection


