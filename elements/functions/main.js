// Message INPUT
const messageStatic = $('.messageStatic');

// Message POPUP
const antiBackground = $('#popupScreen');
const messagePopup = $('#popupContent');


$(document).ready(function () {
    const dropdown = document.querySelector('.dropdown');
    if (dropdown) { // Si Dropdown existe
        dropdown.addEventListener('click', function(e) {
            e.stopPropagation();
            dropdown.classList.toggle('is-active');
        });
    }

    // Navmenu pour mobile / tablette / petit écran
    $(".navbar-burger").click(function () {
        $(".navbar-burger").toggleClass("is-active");
        $(".navbar-menu").toggleClass("is-active");
    });

    getLesPostes();
});


function errorInput(e)
{
    messageStatic.empty();
    messageStatic.css({display: "inline-block"})
    messageStatic.append("<p>" + e + "</p>");
}

function errorPopup(e)
{
    messagePopup.empty();
    $('#popupContent p').empty();
    messagePopup.append("<p>" + e + "</p>");
    antiBackground.css({display: "block"});

    $(window).click((e) => {
        if (e.target == antiBackground[0]) {
            e.stopPropagation();
            antiBackground.css({display: "none"});
        }
    })
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
            url: 'index.php?action=ajax&c=rechercherPoste',
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
            url: 'index.php?action=ajax&c=inscription',
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
            url: 'index.php?action=ajax&c=connexion',
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
            url: 'index.php?action=ajax&c=getLesPostes',
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
            url: 'index.php?action=ajax&c=getLePoste',
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
            url: 'index.php?action=ajax&c=publierPoste',
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
            url: 'index.php?action=ajax&c=aimerPoste',
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
            url: 'index.php?action=ajax&c=supprimerPoste',
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
            url: 'index.php?action=ajax&c=getLesCommentaires',
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
            url: 'index.php?action=ajax&c=publierCommentaire',
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
            url: 'index.php?action=ajax&c=supprimerCommentaire',
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
            url: 'index.php?action=ajax&c=getLesJaimes',
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
            url: 'index.php?action=ajax&c=retirerJaimePoste',
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
            url: 'index.php?action=ajax&c=getLaConversation',
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
            url: 'index.php?action=ajax&c=envoyerMessage',
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

function profilParams()
{
    const amis = $('#amisParam').val();
    const bio = $('#bioParam').val();
    const sujet = $('#sujetParam').val();
    const commentaire = $('#comParam').val();

    $.ajax
    (
        {
            type: 'post',
            url: 'index.php?action=ajax&c=parametreProfil',
            data: 'amis=' + amis + '&bio=' + bio + '&sujet=' + sujet + '&commentaire=' + commentaire,
            success: () => {
                popupParam();
            },
            error: (e) => {
                errorInput(e.statusText);
            }
        }
    )
}



function compteParams()
{
    const avatar = $('#lienAvatar').val();
    const mdp = $('#mdp').val();
    const mdp_confirm = $('#mdp_confirm').val();
    const nom = $('#nom').val();
    const prenom = $('#prenom').val();
    const ville = $('#ville').val();

    $.ajax
    (
        {
            type: 'post',
            url: 'index.php?action=ajax&c=parametreCompte',
            data: 'lienAvatar=' + avatar + '&mdp=' + mdp + '&mdp_confirm=' + mdp_confirm + '&nom=' + nom + '&prenom=' + prenom + '&ville=' + ville,
            success: (e) => {
                popupParam();
            },
            error: (e) => {
                errorInput(e.statusText);
            }
        }
    )
}