// filtersysteem-benodigdheden
const evenementen = document.querySelectorAll('.evenement')
let filter = {};

let locatieOpties
let categorieOpties
let labelOpties;

document.addEventListener('DOMContentLoaded', () => {
    placeholder.style.height = commandos.offsetHeight + 'px';

    // filter object maken
    evenementen.forEach(evenement => {

        const locatie = evenement.dataset.locatie;
        const categorie = evenement.dataset.categorie;
        const label = evenement.dataset.label;
    
        if (!filter[locatie]) {
            filter[locatie] = {
                naam: locatie,
                status: "ON",
                hoeveelheid: 0,
                categorieen: {}
            };
        }
        filter[locatie].hoeveelheid += 1;
    
        if (!filter[locatie].categorieen[categorie]) {
            filter[locatie].categorieen[categorie] = {
                naam: categorie,
                status: "ON",
                hoeveelheid: 0,
                labels: {}
            };
        }
        filter[locatie].categorieen[categorie].hoeveelheid += 1;
    
        if (label) {
            if (!filter[locatie].categorieen[categorie].labels[label]) {
                filter[locatie].categorieen[categorie].labels[label] = {
                    naam: label,
                    status: "ON",
                    hoeveelheid: 0
                };
            }
            filter[locatie].categorieen[categorie].labels[label].hoeveelheid += 1;
        }
    });

    console.log(filter);

    locatieOpties = alleLocaties()
    categorieOpties = relevanteCategorieen();
    labelOpties =  relevanteLabels();

    console.log(locatieOpties);
    console.log(categorieOpties);
    console.log(labelOpties);
});

function alleLocaties() {
    const locatieCounts = {};

    Object.values(filter).forEach(locatie => {
        if (locatie.status === "ON") {
            locatieCounts[locatie.naam] = locatie.hoeveelheid;
        }
    });

    const locatieOpties = Object.entries(locatieCounts)
    .sort((a, b) => b[1] - a[1])
    .map(([naam, hoeveelheid]) => ({
        naam,
        hoeveelheid
    }));

    return locatieOpties
}

function relevanteCategorieen() {
    // Alle mogelijke categorieen eruit halen
    const categoryCounts = {};

    Object.values(filter).forEach(locatie => {
        if (locatie.status === "ON") {
            Object.values(locatie.categorieen).forEach(categorie => {
                if (categoryCounts[categorie.naam]) {
                    categoryCounts[categorie.naam] += categorie.hoeveelheid;
                } else {
                    categoryCounts[categorie.naam] = categorie.hoeveelheid;
                }
            });
        }
    });

    const categorieOpties = Object.entries(categoryCounts)
        .sort((a, b) => b[1] - a[1])
        .map(([categorie, hoeveelheid]) => ({
            naam: categorie,
            hoeveelheid: hoeveelheid
        }));

    return categorieOpties;
}

function relevanteLabels() {

    const labelCounts = {};

    Object.values(filter).forEach(locatie => {
        if (locatie.status === "ON") {
            Object.values(locatie.categorieen).forEach(categorie => {
                if (categorie.status === "ON") {
                    Object.values(categorie.labels).forEach(label => {
                        if (labelCounts[label.naam]) {
                            labelCounts[label.naam] += label.hoeveelheid;
                        } else {
                            labelCounts[label.naam] = label.hoeveelheid;
                        }
                    });
                }
            });
        }
    });

    const labelOpties = Object.entries(labelCounts)
        .sort((a, b) => b[1] - a[1])
        .map(([label, hoeveelheid]) => ({
            naam: label,
            hoeveelheid: hoeveelheid
        }))

    return labelOpties
}