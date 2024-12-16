let placeholder = document.querySelector('#laatst-bijgewerkt');
let commandos = document.querySelector('.commandos');
// knoppen
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
            veranderStatus(knop.dataset.naam, statusLocaties)
            weergeefActieveKnoppen(statusLocaties, zichtbareLocaties, 'locatie')
            zichtbareCategorieen = getZichtbareCategorieen(data);
            maakCategorieKnoppen()
            zichtbareLabels = getZichtbareLabels(data);
        } else if (actieveFilter.id === 'categorie') {
            veranderStatus(knop.dataset.naam, statusCategorieen)
            weergeefActieveKnoppen(statusCategorieen, zichtbareCategorieen ,'categorie')
            zichtbareLabels = getZichtbareLabels(data);
        } else if (actieveFilter.id === 'label') {
            
        }


    }

}

function veranderStatus(naam, statusData) {
    let allesOn = statusData.every(item => item.status === "ON");
    let allesOff = statusData.every(item => item.status === "OFF");

    if (!allesOn) {
        statusData.forEach(item => {
            if (item.naam === naam) {
                item.status = (item.status === "ON") ? "OFF" : "ON";
            }
        });
    } else {
        if (statusData.length > 2) {
            statusData.forEach(item => {
                if (item.naam !== naam) {
                    item.status = "OFF";
                }
            });
        } else if (statusData.length === 2) {
            statusData.forEach(item => {
                if (item.naam === naam) {
                    item.status = "OFF";
                }
            });
        } else {
            statusData.forEach(item => {
                if (item.naam === naam) {
                    item.status = "OFF";
                }
            });
        }
    }
    console.log(statusData);
}