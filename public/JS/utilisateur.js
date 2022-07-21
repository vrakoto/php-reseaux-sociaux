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
            url: 'controller/utilisateur.php?u=parametreProfil',
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
            url: 'controller/utilisateur.php?u=parametreCompte',
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