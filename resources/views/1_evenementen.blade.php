@extends('_layouts.head')

@section('title', 'evenementen')

@section('head')
<script src="{{asset('js/filters.js')}}" defer></script>
@endsection

@section('main')
<main>
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
<div class="commandos">
    <div class="wat" data-stad="overal">
        <button id="alles" data-soort='categorie'>alles</button>
        @foreach ($categoriesAll as $categorie)
        <button data-soort='categorie'>{{$categorie}}</button>
        @endforeach
    </div>
    @foreach ($steden as $stad => $categories)
    <div class="wat" data-stad="{{$stad}}">
        <button id="alles" data-soort='categorie'>alles</button>
        @foreach ($categories as $categorie)
        <button data-soort='categorie'>{{$categorie}}</button>
        @endforeach
    </div>
    @endforeach
    <div id="waar">
        <button id="alles" data-soort='locatie'>overal</button>
        @foreach ($steden as $stad => $categories)
            <button data-soort='locatie'>{{$stad}}</button>
        @endforeach
    </div>
</div>
</main>
@endsection


