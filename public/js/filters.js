let placeholder = document.querySelector('#laatst-bijgewerkt');
let commandos = document.querySelector('.commandos');

let evenementen = document.querySelectorAll('.evenement');

let filterKeuzes = document.querySelectorAll('#filters button');
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

const bufferVerticaal = parseFloat(window.getComputedStyle(document.querySelector('div.commandos div')).marginBottom) * 3;
const bufferHorizontaal = parseFloat(window.getComputedStyle(document.querySelector('div.commandos div button')).margin);


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
    if (knop) {
        knopIndrukken(knop)
    } else {
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
})


/*/ / BIJ HET DRUKKEN VAN EEN KNOP / /*/
function knopIndrukken(knop) {
    console.log(knop);
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
    const categorieGroep = document.querySelector(".wat[data-stad='" + locatie.naam + "']");
    
    categorieGroep.classList.remove('actief')   
    locatieGroep.classList.remove('actief')

    knoppen.forEach(knop => {

        if (knop.dataset.soort === 'locatie' && gekozenFilter.dataset.filter === 'locatie') {
            locatieGroep.classList.add('actief')

            if (locatie.naam === knop.innerHTML) {
                console.log(locatie.categorieen.length); //dees kan dus nooit 2 geven, maar dan eerder 1 omdat in de blade file al gefilterd wordt eigenlijk... beetje omslachtig, maar kijkt, ik schrijf het hier dus op voor de zekerheid he
                knop.classList.add('actief');
                if (locatie.naam === 'overal') {
                    gekozenFilter.innerHTML = knop.innerHTML;
                    gekozenFilter.classList.add('rond');
                } else {
                    gekozenFilter.innerHTML = knop.innerHTML;
                    gekozenFilter.classList.remove('rond');
                }

                const categorie = locatie.categorieen.find(cat => cat.status === "ON");
                if (categorie.naam === 'alles') {
                    categorieFilter.innerHTML = categorie.naam;
                    categorieFilter.classList.add('rond');
                } else {
                    categorieFilter.innerHTML = categorie.naam;
                    categorieFilter.classList.remove('rond');
                }

            } else {
                knop.classList.remove('actief');
            }
        } else if (knop.dataset.soort === 'categorie' && gekozenFilter.dataset.filter === 'categorie') {
            const actieveLocatie = systeem.locaties.find(loc => loc.status === "ON");
            const categorie = actieveLocatie.categorieen.find(cat => cat.naam === knop.innerHTML);
            
            categorieGroep.classList.add('actief')
            
            if (categorie && categorie.status === 'ON') {
                knop.classList.add('actief');
                if (categorie.naam === 'alles') {
                    gekozenFilter.innerHTML = knop.innerHTML
                    gekozenFilter.classList.add('rond');
                } else {
                    gekozenFilter.innerHTML = knop.innerHTML;
                    gekozenFilter.classList.remove('rond');
                }
            } else {
                knop.classList.remove('actief');
            }
        }
    });

    placeholder.style.height = commandos.offsetHeight + 'px';
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