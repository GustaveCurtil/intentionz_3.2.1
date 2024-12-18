

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


    kalenderDagen.forEach(dag => {

        if (!dag.classList.contains('voorbij')) {
            dag.addEventListener('click', (e) => {
                if (dag.classList.contains('actief')) {
                    dag.classList.remove('actief')
                } else {
                    dag.classList.add('actief')
                }
            })
        }
    });


})

