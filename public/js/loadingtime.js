let formulieren = document.querySelectorAll('form')

const loadingStates = ['', '.', '..', '...'];
let currentIndex = 0;


if (formulieren.length !== 0) {
    formulieren.forEach(formulier => {
        formulier.addEventListener('submit', (e) => {

            let submitButton = formulier.querySelector('input[type="submit"]');
            submitButton.disabled = true;

            submitButton.style.backgroundColor = 'var(--kleur-achtergrond)';
            submitButton.value = 'aan het laden' + loadingStates[currentIndex];

            let loadingInterval = setInterval(() => {
                updateLoadingText(submitButton); // Call updateLoadingText every 250ms
            }, 250);

        })
    });
}

function updateLoadingText(button) {
    button.value = 'aan het laden' + loadingStates[currentIndex]; // Update the text content
    currentIndex = (currentIndex + 1) % loadingStates.length; // Move to the next state, and loop back to the start when we reach the end
}


let datumPlaceholder = document.querySelector('header div#datum');

datumPlaceholder.innerHTML = getFormattedDate();

function getFormattedDate() {
    const daysOfWeek = ["zo", "ma", "di", "wo", "do", "vr", "za"];
    const months = ["jan", "feb", "mrt", "apr", "mei", "jun", "jul", "aug", "sep", "okt", "nov", "dec"];

    const today = new Date();
    const dayOfWeek = today.getDay(); // 0 = zondag, 1 = maandag, ...
    const day = today.getDate(); // Dag van de maand (1-31)
    const month = today.getMonth(); // Maand (0 = januari, 11 = december)

    // Format de datum als "wo 10 dec"
    return `${daysOfWeek[dayOfWeek]} ${day} ${months[month]}`;
}