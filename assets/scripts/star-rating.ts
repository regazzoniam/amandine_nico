// // On récupère toutes les étoiles dans un tableau
// const ratingStars = document.querySelectorAll("[data-value-comment]");
//
// // on boucle sur notre tableau
// ratingStars.forEach(starElement => {
//
//     // on ajoute un add eventlistener sur chaque étoile
//     starElement.addEventListener('click', () => {
//         // on récupère la valeur de data-value-comment ()
//         let note = starElement.getAttribute('data-value-comment');
//         // on récupère l'input note caché (son id est comment_note)
//         const inputNote : HTMLInputElement = document.querySelector("#comment_note");
//         // on affecte la valeur de l'input avec la valeur de l'étoile (stocké dans l'attribut "data-value-comment")
//         inputNote.value = note;
//     });
// });

// Sélectionne les étoiles
let stars: any = document.querySelectorAll('[data-value-comment]');

// Sélectionne notre input, celui hidden qui est lié à notre formulaire CommentType => symfony donne automatiquement un id à nos input
let inputNote: HTMLInputElement = document.querySelector('#comment_note');


// Ajoute un évennement au click pour chaque étoile et le stock dans une variable value (on aura donc une note de 1 à 5 dans la value)
stars.forEach(star => {

    star.addEventListener('click' , () => {

        let note = star.getAttribute('data-value-comment');
        inputNote.value = note;
        console.log(inputNote);

        stars.forEach(star => {
            star.style.color = "white";
        });

        star.style.color = "orange";

        let starPrecedente = star.previousElementSibling;

        while (starPrecedente) {

            starPrecedente.style.color = "orange";
            starPrecedente = starPrecedente.previousElementSibling
        }
    });
});

