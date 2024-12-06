let urlLocatie = document.querySelector('#url_locatie input');
let osm = document.querySelector('#openstreetmap');

if (urlLocatie.value) {
    osm.style.display='none';
} else {
    osm.style.display='block'
}

urlLocatie.addEventListener('input', (e) => {
    if (urlLocatie.value) {
    osm.style.display='none';
} else {
    osm.style.display='block'
}
})