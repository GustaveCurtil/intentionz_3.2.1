@extends('_layouts.head')

@section('title', 'evenement aanmaken')

@section('head')
@include('_partials.metadata')
{{-- <script src="{{ asset('js/compressor.js') }}" defer></script> --}}
<script src="{{ asset('js/editor.js') }}" defer></script>
<script src="{{ asset('js/datetimeplaceholder.js') }}" defer></script>
<script src="{{ asset('js/terugknop.js') }}" defer></script>
<script src="{{asset('js/loadingtime.js')}}" defer></script>
<script src="{{asset('js/openstreetmaps.js')}}" defer></script>
@endsection

@section('terugknop')
<a id="terugknop" href="/">terug zonder opslaan</a>
@endsection

@section('main')
<main id="geen-nav">
    <figure class="poster" @if (isset($event)) style="background-color: {{$event->kleur}}; background-image: url(../media/achtergronden/{{$event->achtergrond_pad}})" @endif><small style='opacity:var(--transparantie)'>ratio 4:3</small>
        <img @if (isset($event)) src="../storage/posters/{{ $event->foto_pad }}" style="left: {{ $event->horizontaal }}%; top: {{ $event->verticaal }}%;" @endif>
    </figure>
    <canvas id="canvas" style="display:none;"></canvas>
    <section  id="aanmaken">
        @gebruiker
        <p>Voorlopig is deze pagina nog niet functioneel als gebruiker (wel als organisatie)</p>
        @endgebruiker
        @if (isset($event))
        <form action="/editor/{{$event->id}}/publiceer" method="post" enctype="multipart/form-data">
        @else
        <form action="publiceer" method="post" enctype="multipart/form-data">
        @endif
            @csrf
            <div id="poster-editor">
                <div>
                    <fieldset id="upload">
                        <label for="foto">foto opladen</label>
                        <input type="file" name="foto" id="foto" accept=".jpg, .jpeg, .png">
                    </fieldset>      
                    <fieldset>
                        <select name="achtergrond_pad" id="achtergrond">
                            <option value="geen">achtergrondbeeld</option>
                            @foreach ($achtergronden as $achtergrond)
                            @if ($errors->any())    
                            <option value="{{ $achtergrond }}" {{ old('achtergrond') == $achtergrond ? 'selected' : '' }}>{{$achtergrond }}</option>
                            @elseif (isset($event))
                            <option value="{{ $achtergrond }}" {{ $event->achtergrond_pad == $achtergrond ? 'selected' : '' }}>{{$achtergrond }}</option>
                            @else
                            <option value="{{ $achtergrond }}" >{{$achtergrond }}</option>
                            @endif
                            @endforeach
                        </select>
                        <input type="color" name="kleur" id="kleur" value="#e1e177">
                    </fieldset>
                </div>
                <fieldset id="sliders">
                    <div>
                        <label for="zoom">zoom</label>
                        <input type="range" name="zoom" id="zoom" min="50" max="400" value="{{ old('zoom') ?? $event->zoom ?? 100 }}" list="zoom-punt">
                        <datalist id="zoom-punt">
                            <option value="100"></option>
                        </datalist>
                    </div>
        
                    <div>
                        <label for="horizontaal">horizontaal</label>
                        <input type="range" name="horizontaal" id="horizontaal" min="-100" max="200" value="{{ old('horizontaal') ?? $event->horizontaal ?? 50 }}" list="horizontaal-punt">
                        <datalist id="horizontaal-punt">
                            <option value="50"></option>
                        </datalist>
                    </div>
        
                    <div>
                        <label for="verticaal">verticaal</label>
                        <input type="range" name="verticaal" id="verticaal" min="-100" max="200" value="{{ old('verticaal') ?? $event->verticaal ?? 50 }}" list="verticaal-punt">
                        <datalist id="verticaal-punt">
                            <option value="50"></option>
                        </datalist>
                    </div>
                </fieldset>
            
            </div>         
        
            @include('_partials.aanmaken.basis')

            @organisatie
            <fieldset>
                <input type="url" name='evenement_url' id='evenement-url' placeholder="website v/h evenement (of organisatie)" 
                @if ($errors->any()) value="{{ old('evenement_url') }}"
                @elseif ($user->organisation->url_website) value="{{ $user->organisation->url_website }}"  @endif>
            </fieldset>

            <fieldset id="categorieen">
                <select name="categorie" id="categorie" required>
                    <option value="" disabled selected hidden>categorie*</option>
                    @foreach ($categories as $categorie => $labels)
                    @if ($errors->any())    
                    <option value="{{ $categorie }}" {{ old('categorie') == $categorie ? 'selected' : '' }}>{{$categorie }}</option>
                    @elseif (isset($event))
                    <option value="{{ $categorie }}" {{ $event->categorie == $categorie ? 'selected' : '' }}>{{$categorie }}</option>
                    @else
                    <option value="{{ $categorie }}">{{$categorie }}</option>
                    @endif
                    @endforeach
                </select>
            
                <input type="text" name="subcategorie" id="subcategorie" placeholder="label" maxlength="22"
                @if ($errors->any()) value="{{ old('subcategorie') }}" 
                @elseif (isset($event)) value='{{ $event->subcategorie}}'
                @endif
                >
            
                <div>
                    @foreach ($categories as $categorie => $labels)
                        @foreach ($labels as $label)
                            <button data-categorie="{{ $categorie }}">{{ $label }}</button>
                        @endforeach
                    @endforeach
                    <button id="nieuweKnop"></button>
                </div>
            </fieldset>
            @endorganisatie

            <fieldset>
                @if ($errors->any())
                <textarea name="beschrijving" id="beschrijving" maxlength="5000" placeholder="beschrijving">{{ old('beschrijving') }}</textarea>
                @elseif (isset($event))
                <textarea name="beschrijving" id="beschrijving" maxlength="5000" placeholder="beschrijving">{{$event->beschrijving}}</textarea>
                @else
                <textarea name="beschrijving" id="beschrijving" maxlength="5000" placeholder="beschrijving"></textarea>
                @endif
            </fieldset>
            
            <input type="submit" value="opslaan">
        </form>
    </section>
</main>
@endsection

@section('script')

<script>
    let editting = false;
    @if (isset($event))
    editting = true;
    @endif
    let categorieen = document.querySelector('#categorieen');
    let knoppen = document.querySelectorAll('#categorieen button');
    let zichtbareKnoppen = [];
    let labelVeld = document.querySelector('#subcategorie')
    let nieuweKnop = document.querySelector("#nieuweKnop");

    document.addEventListener('DOMContentLoaded', function() {
        
        //DIT IS OM DE KLEUR VAN DE SELECT ELEMENT GRIJZIG TE MAKEN WANNEER ER NOG NIETS IS GESELECTEERD!
        const selecta = document.querySelector('#categorie');
        const options = document.querySelectorAll('#categorie option');
        const textarea = document.querySelector('textarea');
        const placeholderColor = window.getComputedStyle(textarea, '::placeholder').color;

        const rgbColor = placeholderColor;
        const rgbMatch = rgbColor.match(/\d+/g);
        const red = rgbMatch[0];
        const green = rgbMatch[1];
        const blue = rgbMatch[2];
        const alpha = 'var(--transparantie)';
        const rgbaColor = `rgba(${red}, ${green}, ${blue}, ${alpha})`;

        if (selecta.value == '') {
            selecta.style.color = rgbaColor;
        } else {
            zichtbareKnoppen = [];
            knoppen.forEach(knop => {
                if (knop.dataset.categorie == selecta.value) {
                    knop.style.display = 'inherit';
                    zichtbareKnoppen.push(knop);
                    knop.classList.add('actief');
                }
            });
        }

        selecta.addEventListener('change', (e) => {
            knoppen.forEach(knop => {
                knop.style.display = 'none';
            });
            zichtbareKnoppen = [];
            selecta.style.color= 'var(--kleur-tekst)';
            knoppen.forEach(knop => {
                if (knop.dataset.categorie == selecta.value) {
                    knop.style.display = 'inherit';
                    zichtbareKnoppen.push(knop);
                }
            });
            inhoudNieuweKnop(labelVeld)
        })

        // EINDE SELECT GRIJSMAKER

        // Toon welke knop is ingedrukt
        knoppen.forEach(knop => {
            knop.addEventListener('click', (e) => {
                e.preventDefault();
                knoppen.forEach(knop => {
                    knop.classList.remove('actief');
                });
                if (knop.innerHTML === labelVeld.value) {
                    labelVeld.value = "";
                } else {
                    labelVeld.value = knop.textContent;
                    knop.classList.add('actief');
                }
                inhoudNieuweKnop(labelVeld)
            })
        });

        // Bij aanpassen inputveld, maak een nieuwe knop en laat deze actief staan.
        labelVeld.addEventListener('input', (e) => {
            knoppen.forEach(knop => {
                knop.classList.remove('actief');
            });
            inhoudNieuweKnop(labelVeld)
        })
    });

    function inhoudNieuweKnop(labelVeld) {
        
        if (labelVeld.value.length > 0) {
            nieuweKnop.innerHTML = labelVeld.value;
            nieuweKnop.style.display = 'inherit';
            nieuweKnop.classList.add('actief');
        } else {
            nieuweKnop.style.display = 'none'
        }

        zichtbareKnoppen.forEach(knop => {
            if (knop.innerHTML === labelVeld.value) {
                knop.classList.add('actief');
                nieuweKnop.style.display = 'none';
                nieuweKnop.classList.remove('actief');
                nieuweKnop.innerHTML = "";
            }
        });
    }


    
</script>

@endsection