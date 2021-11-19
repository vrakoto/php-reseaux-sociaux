$(document).ready(function () {
    // Navmenu pour mobile / tablette / petit écran
    $(".navbar-burger").click(function () {
        $(".navbar-burger").toggleClass("is-active");
        $(".navbar-menu").toggleClass("is-active");
    });

    // Affiche tous les postes
    getLesPostes();
});

// Message INPUT
const msgInput_container = $('.error-message');

// Message POPUP
const msgPopup_container = $('#modal-msg');
const msgPopup = $('#modal-content');

function showErrorInput(e)
{
    msgInput_container.empty();
    msgInput_container.css({display: "block"});
    msgInput_container.append("<p class='error-text'>" + e.statusText + "</p>");
}

function showErrorPopup(e)
{
    msgPopup.empty();
    $('#modal-content p').empty();
    msgPopup.append("<p>" + e.statusText + "</p>");
    msgPopup_container.css({display: "block"});

    $(window).click((e) => {
        if (e.target == msgPopup_container[0]) {
            e.stopPropagation();
            msgPopup_container.css({display: "none"});
        }
    })
}


function getLesPostes()
{
    $.ajax
    (
        {
            type: 'get',
            url: 'controller/ajax.php?action=getLesPostes',
            success: (e) => {
                $('#postes').append(e);
            },
            error: (e) => {
                showErrorInput(e);
            }
        }
    )
}


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
                msgInput_container.css({display: "block"});
                msgInput_container.append("<p class='error-text'>" + e.statusText + "</p>");
                $(".error-text").not(":first").empty();
                const erreurs = JSON.parse(e.responseText);
                for (const champ in erreurs) {
                    const erreur = erreurs[champ];
                    msgInput_container.append("<p class='error-text'>" + erreur + "</p>");
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
                showErrorInput(e);
            }
        }
    )
}

function publierPoste()
{
    let posteMessage = $('#posteMessage').val();
    $.ajax
    (
        {
            type: 'post',
            url: 'controller/ajax.php?action=publierPoste',
            data: 'posteMessage=' + posteMessage,
            success: (e) => {
                $('#posteMessage').val(''); // Supprime tout le contenu dans le textarea
                $('#postes').empty();
                getLesPostes();
            },
            error: (e) => {
                showErrorPopup(e);
            }
        }
    )
}

function supprimerPoste(idPoste)
{
    $.ajax
    (
        {
            type: 'post',
            url: 'controller/ajax.php?action=supprimerPoste',
            data: 'idPoste=' + idPoste,
            success: (e) => {
                $('#postes').empty();
                getLesPostes();
            },
            error: (e) => {
                showErrorPopup(e);
            }
        }
    )
}


function afficherCommenter(lePoste)
{
    $(lePoste).closest('.poste-container').find('.commentaire').toggleClass("toggleCom");
}


function afficherLesCommentaires(idPoste, lePoste)
{
    const divCommentaires = $(lePoste).closest('.poste-container').find('.lesCommentaires');
    $.ajax
    (
        {
            type: 'get',
            url: 'controller/ajax.php?action=afficherLesCommentaires',
            data: 'idPoste=' + idPoste,
            success: (e) => {
                divCommentaires.empty();
                divCommentaires.append(e);
                divCommentaires.toggleClass("toggleCom");
            },
            error: (e) => {
                showErrorPopup(e);
            }
        }
    )
}

function publierCommentaire(idPoste, commentaire)
{
    const message = $(commentaire).prev().val();
    $.ajax
    (
        {
            type: 'post',
            url: 'controller/ajax.php?action=publierCommentaire',
            data: 'idPoste=' + idPoste + '&commentaire=' + message,
            success: (e) => {
                $('#postes').empty();
                $(commentaire).prev().val('');
                getLesPostes();
            },
            error: (e) => {
                showErrorPopup(e);
            }
        }
    )
}


function afficherLesJaimes(idPoste)
{
    $.ajax
    (
        {
            type: 'get',
            url: 'controller/ajax.php?action=afficherLesJaimes',
            data: 'idPoste=' + idPoste,
            success: (e) => {
                msgPopup.empty();
                msgPopup.css({backgroundColor: "unset", border: "2px solid #000"});
                msgPopup.append(e); // Affiche tout le contenu et pas le responseText cf méthode showErrorPopup()
                msgPopup_container.css({display: "block"});

                $(window).click((e) => {
                    if (e.target == msgPopup_container[0]) {
                        e.stopPropagation();
                        msgPopup_container.css({display: "none"});
                    }
                })
            },
            error: (e) => {
                showErrorPopup(e);
            }
        }
    )
}

function aimerPoste(idPoste)
{
    $.ajax
    (
        {
            type: 'post',
            url: 'controller/ajax.php?action=aimerPoste',
            data: 'idPoste=' + idPoste,
            success: (e) => {
                $('#postes').empty();
                getLesPostes();
            },
            error: (e) => {
                showErrorPopup(e);
            }
        }
    )
}

function retirerJaime(idPoste)
{
    $.ajax
    (
        {
            type: 'post',
            url: 'controller/ajax.php?action=retirerJaime',
            data: 'idPoste=' + idPoste,
            success: (e) => {
                $('#postes').empty();
                getLesPostes();
            },
            error: (e) => {
                showErrorPopup(e);
            }
        }
    )
}