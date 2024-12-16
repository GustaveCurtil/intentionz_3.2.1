// filtersysteem-benodigdheden
const evenementen = document.querySelectorAll('.evenement')
let counters = {
    locaties: {},
    categories: {},
    labels: {}
};

function terminigigiriator() {
    counters = {
        locaties: {},
        categories: {},
        labels: {}
    };
    evenementen.forEach(evenement => {
        const locatie = evenement.dataset.locatie;
        const categorie = evenement.dataset.categorie;
        const label = evenement.dataset.label;
        const isWeggefilterd = evenement.classList.contains('wegfilteren');
    
        // Count locaties (always count regardless of 'wegfilteren')
        counters.locaties[locatie] = (counters.locaties[locatie] || 0) + 1;
    
        // Count categories (ignore if 'wegfilteren')
        if (!isWeggefilterd) {
            counters.categories[categorie] = (counters.categories[categorie] || 0) + 1;
        }
    
        // Count labels (ignore if 'wegfilteren' and empty labels)
        if (!isWeggefilterd && label) {
            counters.labels[label] = (counters.labels[label] || 0) + 1;
        }
    });
}

function sorteerFilters(counter) {
    return Object.entries(counter)
        .sort((a, b) => b[1] - a[1]) // Sort descending by count
        .map(entry => entry[0]);    // Extract only the keys
}

function prepareerFilters() {
    const locaties = sorteerFilters(counters.locaties);
    const categories = sorteerFilters(counters.categories);
    const labels = sorteerFilters(counters.labels);

    // Add 'overal' to locaties if more than one location exists
    if (locaties.length > 1) {
        locaties.unshift('overal');
    }

    // Add 'Alles' to categories if more than one location exists
    if (locaties.length > 1) {
        categories.unshift('alles');
    }

    // Add 'Alles' to labels if more than one location exists
    if (locaties.length > 1) {
        labels.unshift('alles');
    }

    return { locaties, categories, labels };
}

