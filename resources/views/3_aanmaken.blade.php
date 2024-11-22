@extends('_layouts.head')

@section('title', 'evenement aanmaken')

@section('head')
{{-- <script src="{{ asset('js/compressor.js') }}" defer></script> --}}
<script src="{{ asset('js/editor.js') }}" defer></script>
@endsection

@section('main')
<main>
    <figure class="poster"><small style='opacity:var(--transparantie)'>ratio 4:3</small><img></figure>
    <canvas id="canvas" style="display:none;"></canvas>
    <section  id="aanmaken">
        @gebruiker
        <p>Voorlopig is deze pagina nog niet functioneel als gebruiker (wel als organisatie)</p>
        @endgebruiker
        <form action="maak-evenenement-openbaar" method="post" enctype="multipart/form-data">
            @csrf
            <div id="poster-editor">
                <div>
                    <fieldset id="upload">
                        <label for="foto">foto opladen</label>
                        <input type="file" name="foto" id="foto" accept=".jpg, .jpeg, .png">
                    </fieldset>      
                    <fieldset>
                        <select name="achtergrond" id="achtergrond">
                            <option value="geen">achtergrondbeeld</option>
                            <option value="konijnen.gif">konijnen.gif</option>
                            <option value="trippen.gif">trippen.gif</option>
                            <option value="vierkanten.gif">vierkanten.gif</option>
                            <option value="hellal.jpeg">hellal.jpeg</option>
                        </select>
                        <input type="color" name="kleur" id="kleur" value="#e1e177">
                    </fieldset>
                </div>
                <fieldset id="sliders">
                    <div>
                        <label for="zoom">zoom</label>
                        <input type="range" name="zoom" id="zoom" min="50" max="400" value="100" list="zoom-punt">
                        <datalist id="zoom-punt">
                            <option value="100"></option>
                        </datalist>
                    </div>
        
                    <div>
                        <label for="horizontaal">horizontaal</label>
                        <input type="range" name="horizontaal" id="horizontaal" min="0" max="100" value="50" list="horizontaal-punt">
                        <datalist id="horizontaal-punt">
                            <option value="50"></option>
                        </datalist>
                    </div>
        
                    <div>
                        <label for="verticaal">verticaal</label>
                        <input type="range" name="verticaal" id="verticaal" min="0" max="100" value="50" list="verticaal-punt">
                        <datalist id="verticaal-punt">
                            <option value="50"></option>
                        </datalist>
                    </div>
                </fieldset>
            
            </div>         
        
            @include('_partials.aanmaken.basis')

            @organisatie
            <fieldset id="categorieen">
                <input type="text" name="categorie" id="categorie" placeholder="categorie*" maxlength="22" required>
                <div>
                    @foreach ($categories as $category)
                    <button>{{$category}}</button>
                    @endforeach
                    <button id="nieuweKnop"></button>
                </div>
            </fieldset>
            @endorganisatie

            <fieldset>
                <textarea name="beschrijving" id="beschrijving" maxlength="5000" placeholder="beschrijving">@if ($errors->any()) {{ old('beschrijving') }} @endif</textarea>
            </fieldset>

            <fieldset>
                <input type="url" name='evenement_url' id='evenement-url' placeholder="website evenement" 
                @if ($errors->any()) value="{{ old('evenement_url') }}"
                @elseif ($user->organisation->url_website) value="{{ $user->organisation->url_website }}"  @endif>
            </fieldset>
            <input type="submit" value="opslaan">
        </form>
    </section>
</main>
@endsection

@section('script')

<script>
    let categorieen = document.querySelector('#categorieen');
    let knoppen = document.querySelectorAll('#categorieen button');
    let categorieVeld = document.querySelector('#categorie')
    let nieuweKnop = document.querySelector("#nieuweKnop");

    document.addEventListener('DOMContentLoaded', function() {
        knoppen.forEach(knop => {
            knop.addEventListener('click', (e) => {
                e.preventDefault();
                console.log(e);
                knoppen.forEach(knop => {
                    knop.classList.remove('actief');
                });
                categorieVeld.value = knop.textContent;
                knop.classList.add('actief');
            })
        });


        categorieVeld.addEventListener('input', (e) => {
            knoppen.forEach(knop => {
                knop.classList.remove('actief');
            });
            nieuweKnop.innerHTML = categorieVeld.value;
            nieuweKnop.style.display = 'inherit';
            nieuweKnop.classList.add('actief');
        })


        // (nog niet optimaal!!)
        //Zorgen dat input date en time de placeholder tonen en de label wegdoen als er iets komt
        const inputs = document.querySelectorAll('input[type="date"], input[type="time"]');
    
        inputs.forEach(input => {
            const label = input.nextElementSibling; // Get the associated label
            console.log(label)
            // Hide label on focus or when there's a value
            input.addEventListener('focus', () => {
                label.style.display = 'none';
            });

            input.addEventListener('blur', () => {
                if (input.value === '') {
                    label.style.display = 'flex';
                }
            });

            input.addEventListener('input', () => {
                if (input.value !== '') {
                    label.style.display = 'none';
                } else {
                    label.style.display = 'flex';
                }
            });
        });


        //LOCATIE URL voor OpenStreetMap verstoppen bij een value
        let urlLocatie = document.querySelector('#url_locatie');
        let osm = document.querySelector('#openstreetmap');

        if (urlLocatie.value) {
            osm.style.display='none';
        } else {
            osm.style.display='block'
        }

        urlLocatie.addEventListener('input', (e) => {
            if (urlLocatie.value) {
            osm.style.display='none';
        } else {
            osm.style.display='block'
        }
        })
    });
</script>

@endsection