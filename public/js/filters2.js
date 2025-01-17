let placeholder = document.querySelector('#laatst-bijgewerkt');
let commandos = document.querySelector('.commandos');

let evenementen = document.querySelectorAll('.evenement');
let weken = document.querySelectorAll('.week');

let filters = document.querySelector('#filters')
let filterKeuzes = document.querySelectorAll('#filters button');
let locatieFilter = document.querySelector('#filters button[data-filter="locatie"]')
let categorieFilter = document.querySelector('#filters button[data-filter="categorie"]');
let gekozenFilter;

let categoriegroepPerLocatie = document.querySelectorAll('.wat');
let knoppen = document.querySelectorAll('button');
const waarKnoppen = document.querySelectorAll('#waar button');

let locaties = []
let categorieenPerLocatie = [];
let systeem

let huidigeLocatie = 'overal';
let huidigeCategorie = 'alles';

const bufferVerticaal = parseFloat(window.getComputedStyle(document.querySelector('div.commandos')).padding);
const bufferHorizontaal = parseFloat(window.getComputedStyle(document.querySelector('div.commandos')).padding);


/*/ / BEETJE NAAST KUNNEN KLIKKEN / /*/
document.addEventListener('click', function (event) {
    const knop = dichtBijKnop(event); // Check if the click is near a button
    if (knop) {
        knopIndrukken(knop);
    }
});

function dichtBijKnop(event) {
    if (event.target.tagName === 'BUTTON' || event.target.tagName === 'a') {
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

// ga naar evenement zonder op de knop te drukken
function gaNaar(link, event) {
    let knop = dichtBijKnop(event)
    if (!knop) {
        window.location.href = link;
    }
}



/*/ / WANNEER DE PAGINA START ... / /*/
document.addEventListener('DOMContentLoaded', () => {

    /* ... array 'locaties' en 'categorienPerLocatie' vullen om systeem te maken */
    for (let i = 0; i < waarKnoppen.length; i++) {
        locaties.push(waarKnoppen[i].innerHTML)

        let categorieen = [];
        let watKnoppen = categoriegroepPerLocatie[i].querySelectorAll('button');
        for (let j = 0; j < watKnoppen.length; j++) {
            categorieen.push(watKnoppen[j].innerHTML)
        }
        categorieenPerLocatie.push(categorieen)
    }
    systeem = maakSysteem(locaties, categorieenPerLocatie);

    if (localStorage.getItem('stad')) {
        huidigeLocatie = localStorage.getItem('stad');
        if (huidigeLocatie) {
            veranderLocatie(huidigeLocatie)
        }
    } else {
        localStorage.setItem('stad', huidigeLocatie);
    }

    if (systeem.locaties.length <= 2) {
        systeem.locaties[0].status = 'ON';
    }

    console.log(systeem)

    systeemNaarLooks()
    pasToe();
    placeholderPlaatser()
})


/*/ / BIJ HET DRUKKEN VAN EEN KNOP / /*/
function knopIndrukken(knop) {
    if (knop.dataset.soort === 'locatie') {
        huidigeLocatie = knop.innerHTML;
        localStorage.setItem('stad', huidigeLocatie);
        veranderLocatie(knop.innerHTML);

        if (knop.classList.contains('actief')) {
            gekozenFilter.classList.remove('actief');
            gekozenFilter = null;
        }

    } else if (knop.dataset.soort === 'categorie') {
        const locatie = systeem.locaties.find(loc => loc.naam === huidigeLocatie);
        categorie = knop.innerHTML;
        veranderCategorie(locatie, categorie)
        if (knop.classList.contains('actief')) {
            gekozenFilter.classList.remove('actief');
            gekozenFilter = null;
        }
    } else {
        selecteerFilter(knop);
    }
    systeemNaarLooks()
    pasToe();
    placeholderPlaatser() 
}

/* KIES DE JUISTE FILTER */
function selecteerFilter(knop) {
    if (knop === gekozenFilter) {
        gekozenFilter = null;
        knop.classList.remove('actief');
    } else {
        filterKeuzes.forEach(filterKeuze => {
            filterKeuze.classList.remove('actief')
        });
        knop.classList.add('actief');
        gekozenFilter = knop;
    }
}


/*/ / FUNCTIES / /*/

/* systeem aanmaken */
function maakSysteem(locaties, categorieen) {
    const systeem = {
        locaties: locaties.map((loc, index) => ({
            naam: loc,
            status: index === 0 ? "ON" : "OFF",
            categorieen: categorieen[index].map((cat, index) => ({
                naam: cat,
                status: index === 0 ? "ON" : "OFF"
            }))
        }))
    };
    return systeem;
}

/* wijzigen in systeem uitvoeren */
function veranderLocatie(locatieNaam) {
    systeem.locaties.forEach(locatie => {
        locatie.status = (locatie.naam === locatieNaam) ? "ON" : "OFF";
        if (locatie.status === "ON") {
            // Check if the current category exists in this location
            const categorie = locatie.categorieen.find(cat => cat.naam === huidigeCategorie);
            if (categorie) {
                veranderCategorie(locatie, huidigeCategorie);
            } else {
                locatie.categorieen.forEach(categorie => {
                    if (categorie.status === 'ON') {
                        huidigeCategorie = categorie.naam;
                    }
                });
            }
        }
    });

}
function veranderCategorie(locatie, categorieNaam) {

    locatie.categorieen.forEach(categorie => {
        if (categorie.naam === categorieNaam) {
            categorie.status = "ON";
            huidigeCategorie = categorieNaam;
        } else {
            categorie.status = "OFF";
        }
    });
}

/* systeem vertalen in vorm */
function systeemNaarLooks() {
    let locatieGroep = document.querySelector('#waar')

    const locatie = systeem.locaties.find(loc => loc.status === "ON");
    const categorie = locatie.categorieen.find(cat => cat.status === "ON");

    const categorieGroep = document.querySelector(".wat[data-stad='" + locatie.naam + "']");

    if (systeem.locaties.length <= 2) {
        locatieFilter.style.display = 'none';
    }

    if (locatie.categorieen.length <= 2) {
        categorieFilter.style.display = 'none';
    } else {
        categorieFilter.style.display = 'inherit';
    }

    if (locatie.categorieen.length <= 2 && systeem.locaties.length <= 2) {
        filters.style.display = 'none';
        placeholder.style.display = 'none';
    } 
    
    categorieGroep.classList.remove('actief')   
    locatieGroep.classList.remove('actief')

    locatieFilter.innerHTML = 'locatie:&nbsp;<u>' + locatie.naam + '</u>';
    categorieFilter.innerHTML = 'categorie:&nbsp;<u>' + categorie.naam + '</u>';

    if (gekozenFilter) {
        knoppen.forEach(knop => {

            if (knop.dataset.soort === 'locatie' && gekozenFilter.dataset.filter === 'locatie') {
                locatieGroep.classList.add('actief')
    
                if (locatie.naam === knop.innerHTML) {
                    console.log(locatie.categorieen.length); //dees kan dus nooit 2 geven, maar dan eerder 1 omdat in de blade file al gefilterd wordt eigenlijk... beetje omslachtig, maar kijkt, ik schrijf het hier dus op voor de zekerheid he
                    knop.classList.add('actief');
                } else {
                    knop.classList.remove('actief');
                }
            } else if (knop.dataset.soort === 'categorie' && gekozenFilter.dataset.filter === 'categorie') {             
                categorieGroep.classList.add('actief')
                
                if (categorie.naam === knop.innerHTML) {
                    knop.classList.add('actief');
                } else {
                    knop.classList.remove('actief');
                }
            }
        });
    }

    placeholder.style.height = commandos.offsetHeight + 'px';
}

//wat als er geen evenementen zijn voor die week
function placeholderPlaatser() {
    weken.forEach(week => {
        const evenementen = week.querySelectorAll('.evenement:not(.wegfilteren)');
        
        // Check if the 'geen-evenementen' div already exists
        const existingPlaceholder = week.querySelector('.geen-evenementen');
        
        // If no evenementen and no existing placeholder, create a new placeholder
        if (evenementen.length === 0 && !existingPlaceholder) {
            const geenEvenementen = document.createElement('div');
            geenEvenementen.classList.add('geen-evenementen');
            geenEvenementen.textContent = 'geen evenementen';
    
            // Append the new placeholder div to the week element
            week.appendChild(geenEvenementen);
        }
        
        // If there are evenementen, remove the placeholder if it exists
        if (evenementen.length > 0 && existingPlaceholder) {
            existingPlaceholder.remove();
        }
    });
}

/*/ / FILTEREN / /*/
function pasToe() {
    evenementen.forEach(evenement => {

        const actieveLocatie = systeem.locaties.find(loc => loc.status === "ON");

        if (!actieveLocatie) {
            console.error('No active location found');
            return;
        }

        const actieveCategorie = actieveLocatie.categorieen.find(cat => cat.status === "ON");

        if (!actieveCategorie) {
            console.error('No active category found');
            return;
        }

        let stadfilter = (actieveLocatie.naam.toLowerCase() === "overal" || evenement.dataset.stad.toLowerCase() === actieveLocatie.naam.toLowerCase());
        let categoriefilter = (actieveCategorie.naam.toLowerCase() === "alles" || evenement.dataset.categorie.toLowerCase() === actieveCategorie.naam.toLowerCase());

        if (!stadfilter || !categoriefilter) {
            evenement.classList.add('wegfilteren');
        } else {
            evenement.classList.remove('wegfilteren');
        }
    });
}