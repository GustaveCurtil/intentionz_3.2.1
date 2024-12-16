

// kalenderShmee
let kalenderDagen = document.querySelectorAll('td');
const vandaag = new Date();  // Today's date
const vandaagKloon = new Date(vandaag);  // Kloon of today, to keep 'vandaag' unchanged
const eersteDag = vandaagKloon.getDate() - vandaagKloon.getDay() + 1;
const eersteDagDatum = new Date(vandaagKloon.setDate(eersteDag));
vandaag.setHours(0, 0, 0, 0);
eersteDagDatum.setHours(0, 0, 0, 0);
const maanden = ["jan", "feb", "mrt", "apr", "mei", "jun", "jul", "aug", "sep", "okt", "nov", "dec"];

document.addEventListener('DOMContentLoaded', () => {
    placeholder.style.height = commandos.offsetHeight + 'px';

    for (let i = 0; i < kalenderDagen.length; i++) {
        let dag = kalenderDagen[i].querySelector('span:nth-of-type(2)');
        let maand = kalenderDagen[i].querySelector('span:nth-of-type(3)');

        let datum = new Date(eersteDagDatum);
        datum.setDate(eersteDagDatum.getDate() + i); 

        dag.innerHTML = datum.getDate();
        maand.innerHTML = maanden[datum.getMonth()];

        if (datum < vandaag ) {
            kalenderDagen[i].classList.add('voorbij');
        }
    }

    

    filterRectifiator(locatieOpties, 'locatie')
    filterRectifiator(categorieOpties, 'categorie')
    filterRectifiator(labelOpties, 'label')
    console.log(categorieOpties);
    console.log(labelOpties);
})

function filterRectifiator(opties, filter) {
    let filterDiv = document.getElementById(filter);
    opties.forEach(optie => {
        let button = document.createElement('button');
        button.innerHTML = optie.naam + " (" + optie.hoeveelheid + ")";
        filterDiv.appendChild(button);
    });
    filterKnoppen = document.querySelectorAll('button:not([data-filter])')
}
