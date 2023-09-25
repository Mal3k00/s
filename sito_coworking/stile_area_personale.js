// Funzione per  l'animazione all'hover sui link degli spazi di coworking
function handleCoworkingLinkHover(event) {
    const link = event.target;

    link.style.transition = 'background-color 0.3s ease';
    link.style.backgroundColor = '#45a049';
}

function handleCoworkingLinkLeave(event) {
    const link = event.target;

    link.style.transition = 'background-color 0.3s ease';
    link.style.backgroundColor = '#4CAF50';
}


const coworkingLinks = document.querySelectorAll('a[href^="informazioni_area.php"]');
coworkingLinks.forEach(link => {
    link.addEventListener('mouseenter', handleCoworkingLinkHover);
    link.addEventListener('mouseleave', handleCoworkingLinkLeave);
});
