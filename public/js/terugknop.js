document.addEventListener('DOMContentLoaded', (e) => {
    let vorigeURL = localStorage.getItem('vorigeURL');
    const terugKnop = document.getElementById('terugknop');
    
    if (vorigeURL) {
        terugKnop.href = vorigeURL; // Set href to the stored URL
    }
})
