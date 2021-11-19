<?php foreach ($lesJaimes as $jaime) : ?>
    <?php
    $idPoste = htmlentities($jaime['idPoste']);
    $idAuteur = htmlentities($jaime['auteur']);
    $avatar = htmlentities($jaime['avatar']);
    $nom = htmlentities($jaime['nom']);
    $prenom = htmlentities($jaime['prenom']); ?>

    <div class="card mb-2">
        <div class="is-flex">
            <div class="card">
                <figure class="image is-48x48">
                    <img src="<?= $avatar ?>" alt="Avatar de l'auteur du poste">
                </figure>
            </div>
            <a href="index.php?action=consulterProfil&idUtilisateur=<?= $idAuteur ?>" target="_blank" class="is-4 is-underlined mr-5"><?= $prenom . ' ' . $nom ?></a>
        </div>
    </div>
<?php endforeach ?>