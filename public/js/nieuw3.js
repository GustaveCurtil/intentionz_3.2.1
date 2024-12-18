let placeholder = document.querySelector('#laatst-bijgewerkt');
let commandos = document.querySelector('.commandos');

let knoppen = document.querySelectorAll('button');
let selectieKnoppen = document.querySelectorAll("[data-filter]");
let filterKnoppen;
let filters = document.querySelectorAll('.filter');

// voor naast de knoppen te kunnen drukken
const bufferVerticaal = parseFloat(window.getComputedStyle(document.querySelector('div.commandos')).padding);
const bufferHorizontaal = parseFloat(window.getComputedStyle(document.querySelector('div.commandos')).padding);


/*/ / ZOEKEN NAAR KNOP, IN DE BUURT of GEEN KNOP / /*/
document.addEventListener('click', function (event) {
    const knop = dichtBijKnop(event); // Check if the click is near a button
    if (knop) {
        knopIndrukken(knop);
    }
});
function gaNaar(link, event) {
    let knop = dichtBijKnop(event)
    if (!knop) {  // ga naar evenement zonder op de knop te drukken, en anders... zal die wel op de knop drukken.
        window.location.href = link;
    }
}
function dichtBijKnop(event) {
    if (event.target.tagName === 'BUTTON') {
        return event.target;
    }

    for (let knop of knoppen) {
        const rect = knop.getBoundingClientRect();

        const left = rect.left - bufferHorizontaal;
        const right = rect.right + bufferHorizontaal;
        const top = rect.top - bufferVerticaal;
        const bottom = rect.bottom + bufferVerticaal;

        // If the click is within the button's expanded area, return the button (knop)
        if (
            event.clientX >= left &&
            event.clientX <= right &&
            event.clientY >= top &&
            event.clientY <= bottom
        ) {
            return knop;
        }
    }
    // Return false if no button was clicked nearby
    return false;
}

/*/ / EINDELIJK EEN KNOP KUNNEN INDRUKKEN / /*/
function knopIndrukken(knop) {
    if (knop.getAttribute('data-filter')) {
        if (!knop.classList.contains('eenzaad')) {
            if (knop.classList.contains('actief')) {
                knop.classList.remove('actief'); 
            } else {
                selectieKnoppen.forEach(knop => {
                    knop.classList.remove('actief');
                });
                knop.classList.add('actief');
            }
            //juiste filter weergeven
            filters.forEach(filter => {
                if (filter.id === knop.getAttribute('data-filter')) {
                    if (filter.classList.contains('actief')) {
                        filter.classList.remove('actief');
                    } else {
                        filters.forEach(filter => {
                            filter.classList.remove('actief');
                        });
                        filter.classList.add('actief');
                    }
                }
            });
    
        }
    } else {
        
        let actieveFilter = knop.parentElement;

        if (actieveFilter.id === 'locatie') {
            veranderStatus('locatie', knop.dataset.naam, statusLocaties, zichtbareLocaties)
            weergeefActieveKnoppen('locatie', statusLocaties, zichtbareLocaties)

            zichtbareCategorieen = getZichtbareCategorieen(data);
            checkStatus(statusCategorieen, zichtbareCategorieen)
            maakKnoppen('categorie', zichtbareCategorieen, statusCategorieen)
            weergeefActieveKnoppen('categorie', statusCategorieen, zichtbareCategorieen)

            zichtbareLabels = getZichtbareLabels(data);
            checkStatus(statusLabels, zichtbareLabels)
            maakKnoppen('label', zichtbareLabels, statusLabels)
            weergeefActieveKnoppen('label', statusLabels, zichtbareLabels)

        } else if (actieveFilter.id === 'categorie') {

            veranderStatus('categorie', knop.dataset.naam, statusCategorieen, zichtbareCategorieen)
            weergeefActieveKnoppen('categorie', statusCategorieen, zichtbareCategorieen)

            zichtbareLabels = getZichtbareLabels(data);
            checkStatus(statusLabels, zichtbareLabels)
            maakKnoppen('label', zichtbareLabels, statusLabels)
            weergeefActieveKnoppen('label', statusLabels, zichtbareLabels)

        } else if (actieveFilter.id === 'label') {

            veranderStatus('label', knop.dataset.naam, statusLabels,  zichtbareLabels)
            weergeefActieveKnoppen('label', statusLabels, zichtbareLabels)
        }

        wegfilteren();
    }

}

function veranderStatus(soort, naam, statusData, zichtbareData) {
    statusData.forEach(item => {
        if (item.naam === naam) {
            if (item.status === "ON") {
                item.status = 'OFF'
                const zichtbareStatusData = statusData.filter(item => zichtbareData.some(zichtbaarItem => zichtbaarItem.naam === item.naam)).map(item => ({naam: item.naam, status: item.status}));
                const anyOn = zichtbareStatusData.some(otherItem => otherItem.status === "ON");
                if (!anyOn) {
                    statusData.forEach(otherItem => {
                        if (zichtbareData.some(zichtbaarItem => zichtbaarItem.naam === otherItem.naam)) {
                            otherItem.status = 'MAAGD';
                        }
                    });
                }
            } else if (item.status === "MAAGD") {
                item.status = 'ON'
                statusData.forEach(item => {
                    if (item.naam !== naam && zichtbareData.some(zichtbaarItem => zichtbaarItem.naam === item.naam)) {
                        item.status = 'OFF'
                    }
                })
            } else if (item.status === "OFF") {
                item.status = 'ON';
            }
        }
    });
}

function checkStatus(statusData, zichtbareData) {
    // Filter statusData to include only items that are also in zichtbareData based on 'naam'
    const zichtbareStatusData = statusData.filter(item => 
        zichtbareData.some(zichtbaarItem => zichtbaarItem.naam === item.naam)
    );

    // Check if any item in zichtbareStatusData has the status 'ON'
    const anyOn = zichtbareStatusData.some(item => item.status === "ON");

    // If no item has status 'ON', change all the items in zichtbareStatusData to 'MAAGD'
    if (!anyOn) {
        zichtbareStatusData.forEach(item => {
            item.status = 'MAAGD';
        });
    }
}