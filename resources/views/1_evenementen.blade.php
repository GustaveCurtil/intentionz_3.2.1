@extends('_layouts.head')

@section('title', 'Catalogus')

@section('head')
@include('_partials.metadata')
<script src="{{asset('js/filters.js')}}" defer></script>
@endsection

@section('main')
<main>
<section class="evenementen">
    @foreach ($events as $event)
    <div class="evenement" data-stad="{{ $event->stad }}" data-categorie="{{ $event->categorie }}"  onclick="gaNaar('{{ url('/' . $event->id . '-' . \Str::slug($event->titel)) }}', event)" >
        @include('_partials.evenement')
    </div>
    @endforeach
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
        <button data-filter='locatie'>locatie: <u>overal</u></button>
        <button data-filter='categorie'>categorie: <u>alles</u></button>
        {{-- <button class="rond">subcategorie</button>
        <button class="rond">periode</button> --}}
    </div>
</div>
</main>
@endsection


