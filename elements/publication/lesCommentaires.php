<?php foreach ($lesCommentaires as $commentaire) : ?>
    <?php
    $idCommentaire = htmlentities($commentaire['idCommentaire']);
    $idPoste = htmlentities($commentaire['idPoste']);
    $idAuteur = htmlentities($commentaire['auteur']);
    $message = $commentaire['message'];
    $date = htmlentities($commentaire['datePublication']);
    $avatar = htmlentities($commentaire['avatar']);
    $nom = htmlentities($commentaire['nom']);
    $prenom = htmlentities($commentaire['prenom']); ?>

    <div class="unCommentaire card mt-5" <?php if ($connecte && $sid === $idAuteur): ?>style="border: 1px solid #00c4a7"<?php endif ?>>
        <div class="is-flex is-align-items-center">
            <div class="card">
                <figure class="image is-48x48">
                    <img src="<?= $avatar ?>" alt="Avatar de l'auteur du poste">
                </figure>
            </div>

            <a href="index.php?action=consulterProfil&id=<?= $idAuteur ?>" target="_blank" class="is-4 is-underlined mr-5"><?= $prenom . ' ' . $nom ?></a>
            <p><?= $message ?></p>
            
            <?php if ($connecte && $sid === $idAuteur): ?>
                <i class="fas fa-trash" onclick="supprimerCommentaire('<?= $idPoste ?>', '<?= $idCommentaire ?>', this)"></i>
            <?php endif ?>
        </div>

        <p style="font-size: .8rem;"><?= $date ?></p>
    </div>
<?php endforeach ?>