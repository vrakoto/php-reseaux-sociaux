// Navmenu pour mobile / tablette / petit écran
$(document).ready(function () {
    $(".navbar-burger").click(function () {
        $(".navbar-burger").toggleClass("is-active");
        $(".navbar-menu").toggleClass("is-active");
    });
});

function verificationInscription()
{
    let identifiant = $('#id').val();
    let nom = $('#nom').val();
    let prenom = $('#prenom').val();
    let mdp = $('#mdp').val();
    let sexe = $('#sexe').val();
    let dateNaissance = $('#dateNaissance').val();
    let ville = $('#ville').val();

    $.ajax
    (
        {
            type: 'post',
            url: 'controller/ajax.php?action=inscription',
            data: 'identifiant=' + identifiant + '&nom=' + nom + '&prenom=' + prenom + '&mdp=' + mdp + '&sexe=' + sexe + '&dateNaissance=' + dateNaissance + '&ville=' + ville,
            success: (e) => {
                window.location.href = "index.php?action=pageConnexion";
            },
            error: (e) => {
                $('.error-message').css({display: "block"});
                $('.error-message').append("<p class='error-text'>" + e.statusText + "</p>");
                $(".error-text").not(":first").empty();
                const erreurs = JSON.parse(e.responseText);
                for (const champ in erreurs) {
                    const erreur = erreurs[champ];
                    $('.error-message').append("<p class='error-text'>" + erreur + "</p>");
                }
            }
        }
    )
}

function verificationConnexion()
{
    let id = $('#id').val();
    let mdp = $('#mdp').val();
    $.ajax
    (
        {
            type: 'post',
            url: 'controller/ajax.php?action=connexion',
            data: 'id=' + id + '&mdp=' + mdp,
            success: (e) => {
                window.location.href = "index.php?action=accueil";
            },
            error: (e) => {
                $('.error-message').empty();
                $('.error-message').css({display: "block"});
                $('.error-message').append("<p class='error-text'>" + e.statusText + "</p>");
            }
        }
    )
}