let formulieren = document.querySelectorAll('form')
let loading = document.querySelector('#loading');
let bolletjes = document.querySelector('#loading span');
let time = document.querySelector('#time');

const loadingStates = ['', '.', '..', '...'];
let currentIndex = 0;

if (formulieren.length !== 0) {
    formulieren.forEach(formulier => {
        formulier.addEventListener('submit', (e) => {
            loading.style.display = 'inherit';
            time.style.display = 'none';

            setInterval(updateLoadingText, 250);

        })
    });
}

function updateLoadingText() {
    bolletjes.textContent = loadingStates[currentIndex]; // Update the text content
    currentIndex = (currentIndex + 1) % loadingStates.length; // Move to the next state, and loop back to the start when we reach the end
}

function updateDateTime() {
    const now = new Date();
    const daysOfWeek = ['zo', 'ma', 'di', 'wo', 'do', 'vr', 'za'];
    const dayOfWeek = daysOfWeek[now.getDay()];
    const day = now.getDate(), month = now.getMonth() + 1, year = now.getFullYear();
    time.textContent = `${dayOfWeek} ${day < 10 ? '0' + day : day}/${month < 10 ? '0' + month : month}/${year}`;
}

// Wait until DOM is fully loaded before updating date and time
document.addEventListener('DOMContentLoaded', () => {
    updateDateTime();
});
