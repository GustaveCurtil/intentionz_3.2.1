

console.log(evenementen)
console.log(statusLocaties)
console.log(statusCategorieen)
console.log(statusLabels)

function wegfilteren() {
    evenementen.forEach(evenement => {
        evenement.classList.remove('wegfilteren')
        statusLocaties.forEach(item => {
            if (item.naam === evenement.getAttribute('data-locatie') && item.status === 'OFF') {
                evenement.classList.add('wegfilteren')
            }
        });
        statusCategorieen.forEach(item => {
            if (item.naam === evenement.getAttribute('data-categorie') && item.status === 'OFF') {
                evenement.classList.add('wegfilteren')
            }
        });
        statusLabels.forEach(item => {
            if (item.naam === evenement.getAttribute('data-label') && item.status === 'OFF') {
                evenement.classList.add('wegfilteren')
            }
        });
    });
}