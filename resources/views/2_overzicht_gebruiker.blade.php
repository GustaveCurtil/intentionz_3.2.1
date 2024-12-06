@extends('_layouts.head')

@section('head')
@include('_partials.metadata')
<script src="{{asset('js/filters.js')}}" defer></script>
@endsection

@section('title', 'overzicht')

@section('main')
<main>
    @if ($userEvents === 0)
    <section>
        <p>Je hebt momenteel geen evenementen bewaard.</p>
        <p>Zolang je de geschiedenis van jouw browser niet wist, worden evenementen die je hebt opgeslaan of waarvoor je een uitnodiging hebt ontvangen hier getoond.</p>
        <p>Als je maximale zekerheid wilt, maak je best een account aan (door op 'Toevoegen' te drukken). Wat extra bien is hieraan, is dat je dan jouw bewaarde evenementen kunt bekijken op eendert welk toestel.</p>
    </section>
    @else
    <section class="evenementen">
        @foreach ($events as $event)
        <div class="evenement" onclick="gaNaar('{{ url('/' . $event->id . '-' . \Str::slug($event->titel)) }}', event)" >
            @include('_partials.evenement')
        </div>
        @endforeach
        <div id="laatst-bijgewerkt"></div>
    </section>
    @endif
</main>

@endsection