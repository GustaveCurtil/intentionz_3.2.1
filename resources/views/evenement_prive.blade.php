@extends('_layouts.head')

@section('title', 'uitnodigingtitel')

@section('main')
<main>
    <figure></figure>
    <section>
        <h3>evenement [voorlopig hardcoded]</h3>
        <p>donderdag 13 mei 2025 om 16u20</p>
        <p>uitgenodigd door Markje</p>
        @if (false)
        <button>uitnodigingslink kopieëren</button>
        <button>evenement aanpassen</button>
        @else
        <button>kalender koppelen</button>
        @endif
    </section>
    <section>
        Een tekst om te beschrijven wat dit hier allemaal is enzo. Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorem sunt nihil commodi nemo sint quae molestiae distinctio accusamus non, consequatur alias! Voluptatibus corrupti a repellat et blanditiis deserunt similique soluta. Lorem ipsum dolor sit amet consectetur adipisicing elit. Nemo provident aliquid, saepe dolorem in animi. Quo porro maxime dolore, nostrum deserunt, repellendus ullam iste soluta illum aperiam iure facere! Consequatur. Lorem ipsum dolor sit, amet consectetur adipisicing elit. Nemo ducimus similique ad! Sit assumenda dignissimos, numquam, saepe ut in aliquam iusto suscipit eveniet cumque possimus expedita laudantium ea dolores porro?
    </section>
    <section id="antwoorden">
        @auth
        <form action="" id="antwoorden">
            <input type="hidden" name="" id="">
            <input type="submit" value="ik ga">
            <input type="submit" value="ik ga niet">
        </form> 
        @else 
        <form action="" id="antwoorden">
            <input type="text" name="" id="">
            <input type="submit" value="ik ga">
            <input type="submit" value="ik ga niet">
        </form>    
        @endauth
    </section>
</main>
@endsection