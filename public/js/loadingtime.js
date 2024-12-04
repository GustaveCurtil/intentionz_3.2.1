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
