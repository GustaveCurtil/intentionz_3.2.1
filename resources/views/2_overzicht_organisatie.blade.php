@extends('_layouts.head')

@section('head')
@include('_partials.metadata')
<script src="{{asset('js/filters.js')}}" defer></script>
@endsection

@section('title', 'overzicht')

@section('main')
<main>
    <section class="evenementen dashboard">
        @foreach ($events as $event)
        <div class="evenement" onclick="gaNaar('{{ url('/' . $event->id . '-' . \Str::slug($event->titel)) }}', event)" >
            @include('_partials.evenement')
        </div>
        @endforeach
        <div id="laatst-bijgewerkt"></div>
    </section>
 
</main>
@endsection