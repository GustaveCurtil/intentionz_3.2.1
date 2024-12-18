

console.log(evenementen)
console.log(statusLocaties)
console.log(statusCategorieen)
console.log(statusLabels)

function wegfilteren() {
    console.log('lol');
    evenementen.forEach(evenement => {
        console.log(evenement);
        statusLocaties.forEach(item => {
            if (item.naam === evenement.getAttribute('data-locatie') && item.status === 'OFF') {
                evenement.classList.add('wegfilteren')
                console.log('lol');
            } else {
                evenement.classList.remove('wegfilteren');
            }
        });
    });
}