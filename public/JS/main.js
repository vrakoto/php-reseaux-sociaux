// Message INPUT
$(document).ready(function () {
    getLesPostes();
});


function errorInput(e)
{
    
}

function errorPopup(e)
{
    
}

function rechercherPoste(type, valeur)
{
    let recherche = 'utilisateur';
    if (type === 'sujet') {
        recherche = 'sujet';
    }

    $.ajax
    (
        {
            type: 'get',
            url: 'index.php?action=rechercherPoste',
            data: 'type=' + recherche + '&valeur=' + valeur,
            success: (e) => {
                $('#postes').empty();
                $('#postes').append(e);
            },
            error: (e) => {
                errorPopup(e.statusText);
            }
        }
    )
}

function verificationInscription()
{
    const identifiant = $('#id').val();
    const nom = $('#nom').val();
    const prenom = $('#prenom').val();
    const mdp = $('#mdp').val();
    const sexe = $('#sexe').val();
    const dateNaissance = $('#dateNaissance').val();
    const ville = $('#ville').val();

    $.ajax
    (
        {
            type: 'post',
            url: 'index.php?action=inscription',
            data: 'identifiant=' + identifiant + '&nom=' + nom + '&prenom=' + prenom + '&mdp=' + mdp + '&sexe=' + sexe + '&dateNaissance=' + dateNaissance + '&ville=' + ville,
            success: () => {
                window.location.href = "index.php?action=pageConnexion";
            },
            error: (e) => {
                messageStatic.css({display: "block"});
                messageStatic.append("<p>" + e.statusText + "</p>");
                $(".messageStatic p").not(":first").empty();
                const erreurs = JSON.parse(e.responseText);
                for (const champ in erreurs) {
                    const erreur = erreurs[champ];
                    messageStatic.append("<p>" + erreur + "</p>");
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
            url: 'index.php?action=connexion',
            data: 'id=' + id + '&mdp=' + mdp,
            success: () => {
                window.location.href = "index.php?action=accueil";
            },
            error: (e) => {
                errorInput(e.statusText);
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
            url: 'index.php?action=getLesPostes',
            success: (e) => {
                $('#postes').append(e);
            },
            error: (e) => {
                errorInput(e.statusText);
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
            url: 'index.php?action=getLePoste',
            data: 'idPoste=' + idPoste,
            success: (e) => {
                lePoste.replaceWith(e);
            },
            error: (e) => {
                errorInput(e.statusText);
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
            url: 'controller/utilisateur.php?u=publierPoste',
            data: 'posteMessage=' + posteMessage,
            success: () => {
                $('#posteMessage').val('');
                $('#postes').empty();
                getLesPostes();
            },
            error: (e) => {
                errorPopup(e.statusText);
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
            url: 'controller/utilisateur.php?u=aimerPoste',
            data: 'idPoste=' + idPoste,
            success: (e) => {
                getLePoste(idPoste, parent);
            },
            error: (e) => {
                errorPopup(e.statusText);
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
            url: 'controller/utilisateur.php?u=supprimerPoste',
            data: 'idPoste=' + idPoste,
            success: (e) => {
                getLePoste(idPoste, parent);
            },
            error: (e) => {
                errorPopup(e.statusText);
            }
        }
    )
}


function ouvrirCommenter(lePoste)
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
            url: 'index.php?action=getLesCommentaires',
            data: 'idPoste=' + idPoste,
            success: (e) => {
                divCommentaires.empty();
                divCommentaires.append(e);
                divCommentaires.css({display: "block"});
            },
            error: (e) => {
                errorPopup(e.statusText);
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
            url: 'controller/utilisateur.php?u=publierCommentaire',
            data: 'idPoste=' + idPoste + '&commentaire=' + message,
            success: (e) => {
                parent.find('#nbCommentaire').text(e);
                getLesCommentaires(idPoste, divCommentaires);
                $(commentaire).prev().val('');
            },
            error: (e) => {
                errorPopup(e.statusText);
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
            url: 'controller/utilisateur.php?u=supprimerCommentaire',
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
                errorPopup(e.statusText);
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
            url: 'index.php?action=getLesJaimes',
            data: 'idPoste=' + idPoste,
            success: (e) => {
                if (e !== 'null') {
                    messagePopup.empty();
                    messagePopup.css({backgroundColor: "unset", border: "2px solid #000"});
                    messagePopup.append(e);
                    antiBackground.css({display: "block"});

                    antiBackground.click((e) => {
                        if (e.target === antiBackground[0]) {
                            messagePopup.css({backgroundColor: "#f8d7da", border: "unset"});
                            antiBackground.css({display: "none"});
                        }
                    });
                }
            },
            error: (e) => {
                errorPopup(e.statusText);
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
            url: 'controller/utilisateur.php?u=retirerJaimePoste',
            data: 'idPoste=' + idPoste,
            success: (e) => {
                getLePoste(idPoste, parent);
            },
            error: (e) => {
                errorPopup(e.statusText);
            }
        }
    )
}

function rechercherAmiConversation()
{
    const input = $('#rechercheAmiConv').val();
    const inputFilter = input.toLowerCase();
    $('.leContact').each(function() {
        const leAmi = $(this).find('.leContact-nom').text();

        if (!leAmi.includes(inputFilter)) {
            $(this).addClass("filtrerContact");
        } else {
            $(this).removeClass("filtrerContact");
        }
    });
}

let idAmiSelectionner = '';
function getLaConversation(idAmi, currentItem)
{
    $(currentItem).css({boxShadow: "10px 10px 10px 10px #333"});
    $('.leContact').not(currentItem).css({boxShadow: "unset"});
    const laConversation = $('#laConversation');
    $.ajax
    (
        {
            type: 'get',
            url: 'controller/utilisateur.php?u=getLaConversation',
            data: 'idAmi=' + idAmi,
            success: (e) => {
                idAmiSelectionner = idAmi;
                laConversation.css({display: "flex"});
                laConversation.empty();
                laConversation.append(e);
                laConversation.scrollTop(laConversation.prop("scrollHeight"));
                
                $('#idAmi').empty();
                $('#idAmi').append(idAmi);

                $('#message').focus();
            },
            error: (e) => {
                errorPopup(e.statusText);
            }
        }
    )
}

function envoyerMessage()
{
    //const image = $('#image').prop('files');
    let message = $('#message');
    $.ajax
    (
        {
            type: 'post',
            url: 'controller/utilisateur.php?u=envoyerMessage',
            data: 'idAmi=' + idAmiSelectionner + '&message=' + message.val(),
            success: (e) => {
                message.val('');
                getLaConversation(idAmiSelectionner);
            },
            error: (e) => {
                errorPopup(e.statusText);
            }
        }
    )
}

$('.tabs-nav a').click(function() {
    $('.tabs-nav li').removeClass('active');
    $(this).parent().addClass('active');

    let currentTab = $(this).attr('href');
    $('.tabs-content .tab').hide();
    $(currentTab).show();

    return false;
});


function popupParam()
{
    $('#success').empty();
    $('#success').append("Profil mis-à-jour !");
    $('#success').css({display: "block"});
}