import './styles/app.css';
import 'bootstrap/dist/css/bootstrap.css';

jquery
const $ = require ('jquery');
window.jQuery = $;
window.$ = $;

document.addEventListener("DOMContentLoaded", function () {
    // Récupérez le bouton par son ID
    var ajoutLivreButton = document.getElementById("ajoutLivreButton");

    // Ajoutez un gestionnaire d'événements pour le clic sur le bouton
    ajoutLivreButton.addEventListener("click", function (event) {
        // Empêchez le comportement par défaut du bouton (par exemple, l'envoi d'un formulaire)
        event.preventDefault();

        // Récupérez l'URL de la route 'ajouter_livre' à partir du bouton
        var url = ajoutLivreButton.getAttribute("data-url");

        // Naviguez vers l'URL de la route
        window.location.href = url;
    });
});