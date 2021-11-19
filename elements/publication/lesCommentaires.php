<?php foreach ($lesCommentaires as $commentaire) : ?>
    <?php
    $idPoste = htmlentities($commentaire['idPoste']);
    $idAuteur = htmlentities($commentaire['auteur']);
    $message = $commentaire['message'];
    $date = htmlentities($commentaire['datePublication']);
    $avatar = htmlentities($commentaire['avatar']);
    $nom = htmlentities($commentaire['nom']);
    $prenom = htmlentities($commentaire['prenom']); ?>

    <div class="card">
        <div class="is-flex mt-5">
            <div class="card">
                <figure class="image is-48x48">
                    <img src="<?= $avatar ?>" alt="Avatar de l'auteur du poste">
                </figure>
            </div>
            <a href="index.php?action=consulterProfil&idUtilisateur=<?= $idAuteur ?>" target="_blank" class="is-4 is-underlined mr-5"><?= $prenom . ' ' . $nom ?></a>
            <p><?= $message ?></p>
        </div>
        <p class="text-grey" style="font-size: .8rem;"><?= $date ?></p>
    </div>
<?php endforeach ?>