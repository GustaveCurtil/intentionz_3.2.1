maakKnoppen('locatie', zichtbareLocaties, statusLocaties)
maakKnoppen('categorie', zichtbareCategorieen, statusCategorieen)
maakKnoppen('label', zichtbareLabels, statusLabels)

function maakKnoppen(soort, zichtbareData, statusData) {
    let knop = document.querySelector('[data-filter="' + soort + '"]')
    let tekst = knop.querySelector('span:last-of-type')

    let filterDiv = document.getElementById(soort);
    filterDiv.innerHTML = '';

    if (zichtbareData.length > 1 && soort === 'label') {
        let button = document.createElement('button');
        button.dataset.naam = 'alles';
        button.innerHTML = 'alles';
        button.classList.add('actief');
        button.classList.add('rond');
        filterDiv.appendChild(button);
    }

    zichtbareData.forEach(locatie => {
        let button = document.createElement('button');
        button.innerHTML = locatie.naam + " (" + locatie.hoeveelheid + ")";
        button.dataset.naam = locatie.naam;
        filterDiv.appendChild(button);
    });
}

function weergeefActieveKnoppen(soort, statusData, zichtbareData) {

    let filterDiv = document.getElementById(soort);
    let knoppen = filterDiv.querySelectorAll('button');
    let actieveKnoppen = filterDiv.querySelectorAll('button.actief')

    let knop = document.querySelector('[data-filter="' + soort + '"]')
    let tekst = knop.querySelector('span:last-of-type')

    const zichtbareStatusData = statusData.filter(item => zichtbareData.some(zichtbaarItem => zichtbaarItem.naam === item.naam)).map(item => ({ naam: item.naam, status: item.status}));
    knoppen.forEach(knop => {
        zichtbareStatusData.forEach(data => {
            if (data.naam === knop.dataset.naam) {
                if (data.status === 'ON') {
                    knop.classList.add('actief');
                    actieveKnoppen = filterDiv.querySelectorAll('button.actief')
                    if (actieveKnoppen.length === 1) {
                        tekst.innerHTML = data.naam
                    } else if (actieveKnoppen.length === zichtbareStatusData.length) {
                        tekst.innerHTML = overalAllesAltijd(soort)
                    } else if (actieveKnoppen.length > 1) {
                        tekst.innerHTML = actieveKnoppen.length + ' selecties';
                    }
                } else {
                    knop.classList.remove('actief');
                    actieveKnoppen = filterDiv.querySelectorAll('button.actief')
                    if (actieveKnoppen.length === 0) {
                        tekst.innerHTML = overalAllesAltijd(soort)
                    }
                }
            }
        }); 
    });
}

function overalAllesAltijd(soort) {
    if (soort === 'locatie') {
        return 'overal'
    } else if (soort === 'periode') {
        return 'altijd'
    } else {
        return 'alles'
    }
}
