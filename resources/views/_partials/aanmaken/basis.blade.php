    
<fieldset>

    <input type="text" name="titel" id="titel" maxlength="100" required 
    placeholder="titel*" 
    @if ($errors->any()) value="{{ old('titel') }}" @endif>

    <div id="tijduur">

        <input type="date" name="datum" id="datum" required placeholder="MM/DD/YYYY">
        <label for="datum">datum*</label>

        <input type="time" name="tijd" id="tijd" required @if ($errors->any()) value="{{ old('tijd') }}" @endif placeholder="tijd">
        <label for="tijd">tijd*</label>    

    </div>

    <div class="adres">

        <input type="text" name="adres" id="adres" maxlength="100" required 
        placeholder="straat en nummer*" 
        @if ($errors->any()) value="{{ old('adres') }}" 
        @elseif ($user->organisation->adres) value="{{ $user->organisation->adres }}"  @endif>

        <input type="text" name="stad" id="stad" maxlength="100" required 
        placeholder="stad*" 
        @if ($errors->any()) value="{{ old('stad') }}"
        @elseif ($user->organisation->stad) value="{{ $user->organisation->stad }}"  @endif>

        <input type="url" name="url_locatie" id="url_locatie" placeholder="url locatie"
        @if ($errors->any()) value="{{ old('url_locatie') }}"
        @elseif ($user->organisation->url_locatie) value="{{ $user->organisation->url_locatie }}"  @endif>
        <div onclick="window.open('https://www.openstreetmap.org', '_blank')" id="openstreetmap">openstreetmap.org</div>

    </div>
    


</fieldset>