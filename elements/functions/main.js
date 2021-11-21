$(document).ready(function () {
    // Navmenu pour mobile / tablette / petit écran
    $(".navbar-burger").click(function () {
        $(".navbar-burger").toggleClass("is-active");
        $(".navbar-menu").toggleClass("is-active");
    });

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

function getLePoste(idPoste, lePoste)
{
    $.ajax
    (
        {
            type: 'get',
            url: 'controller/ajax.php?action=getLePoste',
            data: 'idPoste=' + idPoste,
            success: (e) => {
                lePoste.replaceWith(e);
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
                $('#posteMessage').val('');
                $('#postes').empty();
                getLesPostes();
            },
            error: (e) => {
                showErrorPopup(e);
            }
        }
    )
}

function aimerPoste(idPoste, lePoste)
{
    const parent = $(lePoste).closest('.poste-container');
    $.ajax
    (
        {
            type: 'post',
            url: 'controller/ajax.php?action=aimerPoste',
            data: 'idPoste=' + idPoste,
            success: (e) => {
                getLePoste(idPoste, parent);
            },
            error: (e) => {
                showErrorPopup(e);
            }
        }
    )
}

function supprimerPoste(idPoste, lePoste)
{
    const parent = $(lePoste).closest('.poste-container');
    $.ajax
    (
        {
            type: 'post',
            url: 'controller/ajax.php?action=supprimerPoste',
            data: 'idPoste=' + idPoste,
            success: (e) => {
                getLePoste(idPoste, parent);
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

function getLesCommentaires(idPoste, lePoste)
{
    const divCommentaires = $(lePoste).closest('.poste-container').find('.lesCommentaires');
    $.ajax
    (
        {
            type: 'get',
            url: 'controller/ajax.php?action=getLesCommentaires',
            data: 'idPoste=' + idPoste,
            success: (e) => {
                divCommentaires.empty();
                divCommentaires.append(e);
                divCommentaires.css({display: "block"});
            },
            error: (e) => {
                showErrorPopup(e);
            }
        }
    )
}

function fermerLesCommentaires(lePoste)
{
    $(lePoste).closest('.lesCommentaires').css({display: "none"});
}

function publierCommentaire(idPoste, commentaire)
{
    const message = $(commentaire).prev().val();
    const parent = $(commentaire).closest('.poste-container');
    const divCommentaires = parent.find('.lesCommentaires');

    $.ajax
    (
        {
            type: 'post',
            url: 'controller/ajax.php?action=publierCommentaire',
            data: 'idPoste=' + idPoste + '&commentaire=' + message,
            success: (e) => {
                parent.find('#nbCommentaire').text(e);
                getLesCommentaires(idPoste, divCommentaires);
                $(commentaire).prev().val('');
            },
            error: (e) => {
                showErrorPopup(e);
            }
        }
    )
}

function supprimerCommentaire(idPoste, idCommentaire, lePoste)
{
    const parent = $(lePoste).closest('.poste-container');
    const url = window.location.href;

    $.ajax
    (
        {
            type: 'post',
            url: 'controller/ajax.php?action=supprimerCommentaire',
            data: 'idPoste=' + idPoste + '&idCommentaire=' + idCommentaire,
            success: (e) => {
                parent.find('#nbCommentaire').text(e);
                
                if (url.indexOf("consulterProfil") != -1) {
                    $(lePoste).closest('.unCommentaire').remove();
                } else {
                    getLesCommentaires(idPoste, lePoste);
                }
            },
            error: (e) => {
                showErrorPopup(e);
            }
        }
    )
}


function getLesJaimes(idPoste)
{
    $.ajax
    (
        {
            type: 'get',
            url: 'controller/ajax.php?action=getLesJaimes',
            data: 'idPoste=' + idPoste,
            success: (e) => {
                if (e !== 'null') {
                    msgPopup.empty();
                    msgPopup.css({backgroundColor: "unset", border: "2px solid #000"});
                    msgPopup.append(e);
                    msgPopup_container.css({display: "block"});

                    msgPopup_container.click((e) => {
                        if (e.target === msgPopup_container[0]) {
                            msgPopup.css({backgroundColor: "#f8d7da", border: "unset"});
                            msgPopup_container.css({display: "none"});
                        }
                    });
                }
            },
            error: (e) => {
                showErrorPopup(e);
            }
        }
    )
}

function retirerJaimePoste(idPoste, lePoste)
{
    const parent = $(lePoste).closest('.poste-container');
    $.ajax
    (
        {
            type: 'post',
            url: 'controller/ajax.php?action=retirerJaimePoste',
            data: 'idPoste=' + idPoste,
            success: (e) => {
                getLePoste(idPoste, parent);
            },
            error: (e) => {
                showErrorPopup(e);
            }
        }
    )
}