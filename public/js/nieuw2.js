console.log(statusLocaties);
console.log(statusCategorieen);
console.log(statusLabels);

console.log(zichtbareLocaties);
console.log(zichtbareCategorieen);
console.log(zichtbareLabels);

// filterRectifiator(zichtbareLocaties, 'locatie')
// filterRectifiator(zichtbareCategorieen, 'categorie')
// filterRectifiator(zichtbareLabels, 'label')

// function filterRectifiator(opties, filter) {
//     let filterDiv = document.getElementById(filter);
//     opties.forEach(optie => {
//         let button = document.createElement('button');
//         button.innerHTML = optie.naam + " (" + optie.hoeveelheid + ")";
//         button.dataset.naam = optie.naam;
//         filterDiv.appendChild(button);
//     });
//     filterKnoppen = document.querySelectorAll('button:not([data-filter])')
// }

maakLocatieKnoppen()
maakCategorieKnoppen()

function maakLocatieKnoppen() {
    let knop = document.querySelector('[data-filter="locatie"]')
    let tekst = knop.querySelector('span:last-of-type')
    if (zichtbareLocaties.length === 0) {
        tekst.innerHTML = 'nergens';
    } else if (zichtbareLocaties.length === 1) {
        tekst.innerHTML = zichtbareLocaties[0];
    } else {
        let filterDiv = document.getElementById('locatie');
        let totaal = 0;
        let button = document.createElement('button');

        if (zichtbareLocaties.length > 2) {
            button.dataset.naam = "overal";
            button.classList.add('rond');
            button.classList.add('actief');
            filterDiv.appendChild(button);
        } 
    
        zichtbareLocaties.forEach(locatie => {
            totaal += locatie.hoeveelheid
            let button = document.createElement('button');
            button.innerHTML = locatie.naam + " (" + locatie.hoeveelheid + ")";
            button.dataset.naam = locatie.naam;
            filterDiv.appendChild(button);
        });
        if (zichtbareLocaties.length > 2) {
            button.innerHTML = "overal (" + totaal + ")";
        }
    
        weergeefActieveKnoppen(statusLocaties, zichtbareLocaties, 'locatie')
    }
}

function maakCategorieKnoppen() {
    let knop = document.querySelector('[data-filter="categorie"]')
    let tekst = knop.querySelector('span:last-of-type')

    if (zichtbareCategorieen.length === 0) {
        tekst.innerHTML = 'geen';
    } else if (zichtbareCategorieen.length === 1) {
        tekst.innerHTML = zichtbareCategorieen[0];
    } else {
        let filterDiv = document.getElementById('categorie');
        filterDiv.innerHTML = '';
        let totaal = 0;
        let button = document.createElement('button');

        if (zichtbareCategorieen.length > 2) {
            button.dataset.naam = "alles";
            button.classList.add('rond');
            button.classList.add('actief');
            filterDiv.appendChild(button);
        } 

        zichtbareCategorieen.forEach(locatie => {
            totaal += locatie.hoeveelheid
            let button = document.createElement('button');
            button.innerHTML = locatie.naam + " (" + locatie.hoeveelheid + ")";
            button.dataset.naam = locatie.naam;
            filterDiv.appendChild(button);
        });

        if (zichtbareCategorieen.length > 2) {
            button.innerHTML = "alles (" + totaal + ")";
        }
    }


    weergeefActieveKnoppen(statusCategorieen, zichtbareCategorieen ,'categorie')
}

function weergeefActieveKnoppen(statusData, zichtbareData, soort) {

    let filterDiv = document.getElementById(soort);
    let knoppen = filterDiv.querySelectorAll('button');

    let knop = document.querySelector('[data-filter="' + soort + '"]')
    let tekst = knop.querySelector('span:last-of-type')
    console.log(statusData);
    console.log(zichtbareCategorieen);

    const zichtbareStatusData = statusData.filter(item =>
        zichtbareData.some(zichtbaarItem => zichtbaarItem.naam === item.naam)
    ).map(item => ({
        naam: item.naam,
        status: item.status
    }));

    const aantalOns = zichtbareStatusData.filter(item => item.status === "ON").length;
    const allesOn = aantalOns === zichtbareStatusData.length;
    const allesOff = aantalOns === 0;
    const eenOn = aantalOns === 1;
    const meerdereOns = aantalOns > 1;

    if (allesOn || allesOff) {
        if (zichtbareStatusData.length > 2) {
            knoppen.forEach(knop => {
                knop.classList.remove('actief');
            });
            knoppen[0].classList.add('actief');
        } else {
            if (allesOn) {
                knoppen.forEach(knop => {
                    knop.classList.add('actief');
                });
            }
        }
        if (soort === 'locatie') {
            tekst.innerHTML = 'overal'   
        } else {
            tekst.innerHTML = 'alles'
        }
    } else {
        if (zichtbareStatusData.length > 2) {
            knoppen[0].classList.remove('actief');
        }
        knoppen.forEach(knop => {
            zichtbareStatusData.forEach(data => {
                if (data.naam === knop.dataset.naam) {
                    if (data.status === 'ON') {
                        knop.classList.add('actief');
                        if (eenOn) {
                            tekst.innerHTML = data.naam
                        } else if (meerdereOns) {
                            tekst.innerHTML = aantalOns + ' geselecteerd';
                        }
                    } else {
                        knop.classList.remove('actief');
                    }
                }
            }); 
        });
    }


}
