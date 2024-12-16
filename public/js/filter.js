document.addEventListener('DOMContentLoaded', () => {
    placeholder.style.height = commandos.offsetHeight + 'px';

    terminigigiriator();
    const { locaties, categories, labels } = prepareerFilters();

    filterRectifiator(locaties, 'locatie')
    filterRectifiator(categories, 'categorie')
    filterRectifiator(labels, 'label')
    filterKnoppen = document.querySelectorAll('button:not([data-filter])')

});

function filterRectifiator(opties, filter) {
    let filterDiv = document.getElementById(filter);
    opties.forEach(optie => {
        let button = document.createElement('button');
        button.innerHTML = optie;
        filterDiv.appendChild(button);
    });
}