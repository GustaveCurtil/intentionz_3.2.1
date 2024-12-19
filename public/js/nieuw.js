const data = {};
evenementenData.forEach(event => {
    const { stad, categorie, subcategorie } = event;

    // Ensure locatie exists
    if (!data[stad]) {
        data[stad] = { naam: stad, hoeveelheid: 0, categories: {} };
    }

    // Increment event count for the location
    data[stad].hoeveelheid++;

    // Ensure categorie exists under the locatie
    if (!data[stad].categories[categorie]) {
        data[stad].categories[categorie] = { naam: categorie, hoeveelheid: 0, labels: {} };
    }

    // Increment event count for the category
    data[stad].categories[categorie].hoeveelheid++;

    // Ignore labels with no value
    if (!subcategorie) {
        if (!data[stad].categories[categorie].labels['labelloos']) {
            data[stad].categories[categorie].labels['labelloos'] = { naam: 'labelloos', hoeveelheid: 0 };
        }
        data[stad].categories[categorie].labels['labelloos'].hoeveelheid++;
    } else {
        // Ensure label (subcategorie) exists under the categorie
        if (!data[stad].categories[categorie].labels[subcategorie]) {
            data[stad].categories[categorie].labels[subcategorie] = { naam: subcategorie, hoeveelheid: 0 };
        }

        // Increment event count for the label
        data[stad].categories[categorie].labels[subcategorie].hoeveelheid++;
    }
});

// LIJSTEN MET STATUS FILTERS
const statusLocaties = Object.keys(data).map(key => ({
    naam: data[key].naam,
    status: "MAAGD" // Default status
}));
const statusCategorieen = [
    ...new Set(
        Object.values(data).flatMap(city => Object.keys(city.categories))
    )
].map(category => ({
    naam: category,
    status: "MAAGD" // Default status
}));
const statusLabels = [
    ...new Set(
        Object.values(data).flatMap(city =>
            Object.values(city.categories).flatMap(category =>
                Object.keys(category.labels)
            )
        )
    )
].map(label => ({
    naam: label,
    status: "MAAGD" // Default status
}));


// LIJST MET ZICHTBARE FILTERS
let zichtbareLocaties;
let zichtbareCategorieen = getZichtbareCategorieen(data);
let zichtbareLabels = getZichtbareLabels(data);

zichtbareLocaties = Object.values(data)
.map(city => ({
    naam: city.naam,
    hoeveelheid: city.hoeveelheid
}))
.sort((a, b) => b.hoeveelheid - a.hoeveelheid);

function getZichtbareCategorieen(data) {
    const activeLocaties = statusLocaties
        .filter(locatie => locatie.status === "ON" || locatie.status === "MAAGD")
        .map(locatie => locatie.naam);

    const categories = activeLocaties.flatMap(locatieNaam => {
        const locatie = data[locatieNaam];
        return Object.values(locatie.categories).map(category => ({
            naam: category.naam,
            hoeveelheid: category.hoeveelheid
        }));
    });

    const mergedCategories = categories.reduce((acc, category) => {
        acc[category.naam] = (acc[category.naam] || 0) + category.hoeveelheid;
        return acc;
    }, {});

    return Object.entries(mergedCategories)
        .map(([naam, hoeveelheid]) => ({ naam, hoeveelheid }))
        .sort((a, b) => b.hoeveelheid - a.hoeveelheid); // Descending order by hoeveelheid
}

function getZichtbareLabels(data) {
    const zichtbareStatusCategorieen = statusCategorieen.filter(item =>
        zichtbareCategorieen.some(zichtbaarItem => zichtbaarItem.naam === item.naam)
    ).map(item => ({
        naam: item.naam,
        status: item.status
    }));
    // Get the names of the categories from zichtbareCategorieen (already filtered and sorted)
    const actieveCategorieenNamen = zichtbareStatusCategorieen
    .filter(categorie => categorie.status === "ON" || categorie.status === "MAAGD")
    .map(categorie => categorie.naam);

    // Extract the labels only from the categories that are in zichtbareCategorieen
    const labels = Object.values(data).flatMap(city => {
        return Object.values(city.categories)
            // Check if the category is in zichtbareCategorieen
            .filter(category => actieveCategorieenNamen.includes(category.naam))
            .flatMap(category => 
                Object.values(category.labels).map(label => ({
                    naam: label.naam,
                    hoeveelheid: label.hoeveelheid
                }))
            );
    });

    // Step 3: Merge labels with the same name and sum their "hoeveelheid"
    const mergedLabels = labels.reduce((acc, label) => {
        acc[label.naam] = (acc[label.naam] || 0) + label.hoeveelheid;
        return acc;
    }, {});

    // Step 4: Convert merged results to an array and sort by "hoeveelheid"
    return Object.entries(mergedLabels)
        .map(([naam, hoeveelheid]) => ({ naam, hoeveelheid }))
        .sort((a, b) => b.hoeveelheid - a.hoeveelheid); // Descending order by hoeveelheid
}