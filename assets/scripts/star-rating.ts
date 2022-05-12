// On récupère toutes les étoiles dans un tableau 
const ratingStars = document.querySelectorAll("[data-value-comment]");

// on boucle sur notre tableau
ratingStars.forEach(starElement => {
    
    // on ajoute un add eventlistener sur chaque étoile
    starElement.addEventListener('click', () => {
        // on récupère la valeur de data-value-comment ()
        let note = starElement.getAttribute('data-value-comment');
        // on récupère l'input note caché (son id est comment_note)
        const inputNote : HTMLInputElement = document.querySelector("#comment_note");
        // on affecte la valeur de l'input avec la valeur de l'étoile (stocké dans l'attribut "data-value-comment")
        inputNote.value = note;
    });
});
