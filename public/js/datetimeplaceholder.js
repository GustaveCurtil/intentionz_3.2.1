document.addEventListener('DOMContentLoaded', (e) => {
    // (nog niet optimaal!!)
    //Zorgen dat input date en time de placeholder tonen en de label wegdoen als er iets komt
    const inputs = document.querySelectorAll('input[type="date"], input[type="time"]');

    inputs.forEach(input => {
        const label = input.nextElementSibling; // Get the associated label
        console.log(label)
        // Hide label on focus or when there's a value
        input.addEventListener('focus', () => {
            label.style.display = 'none';
        });

        input.addEventListener('blur', () => {
            if (input.value === '') {
                label.style.display = 'flex';
            }
        });

        input.addEventListener('input', () => {
            if (input.value !== '') {
                label.style.display = 'none';
            } else {
                label.style.display = 'flex';
            }
        });
    });
})  
