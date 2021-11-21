<?= includeCSS('poste') ?>

<?php foreach ($publications as $publication) : ?>
    <?php
    $idPoste = htmlentities($publication['id']);
    $idAuteur = htmlentities($publication['auteur']);
    $avatar = htmlentities($publication['avatar']);
    $nom = htmlentities($publication['nom']);
    $prenom = htmlentities($publication['prenom']);
    $date = htmlentities($publication['datePublication']);
    $nbCommentaires = (int)count($pdo->getLesCommentaires($idPoste));
    $nbJaimes = (int)count($pdo->getLesJaimes($idPoste));
    ?>

    <div class="poste-container">
        <div class="card mt-5">
            <div class="card-content">
                <div class="media">
                    <div class="media-left">
                        <figure class="image is-48x48">
                            <img src="<?= $avatar ?>" alt="Avatar de l'auteur du poste">
                        </figure>
                    </div>
                    <div class="media-content">
                        <p class="title is-4 mb-0"><?= $prenom . ' ' . $nom ?></p>
                        <a class="is-inline-block is-underlined subtitle is-6" href="index.php?action=consulterProfil&id=<?= $idAuteur ?>">@<?= $idAuteur ?></a>
                    </div>
                </div>

                <div class="content">
                    <?= $publication['message'] ?>
                    <br>
                    <p class="is-size-6"><?= $date ?></p>
                </div>
            </div>

            <div class="interaction is-flex is-justify-content-space-between mb-5">
                <a class="is-underlined" onclick="getLesJaimes('<?= $idPoste ?>')"><span id="nbJaime"><?= $nbJaimes ?></span> J'aime<?php if ($nbJaimes > 1): ?>s<?php endif ?></a>
                <a class="is-underlined" onclick="getLesCommentaires('<?= $idPoste ?>', this)"><span id="nbCommentaire"><?= $nbCommentaires ?></span> Commentaire<?php if ($nbCommentaires > 1): ?>s<?php endif ?></a>
            </div>

            <footer class="card-footer">

                <?php if ($connecte) : ?>
                    <?php if (!$pdo->aAimer($idPoste)): ?>
                        <button class="card-footer-item" onclick="aimerPoste('<?= $idPoste ?>', this)">Aimer</button>
                    <?php else: ?>
                        <button class="card-footer-item" onclick="retirerJaimePoste('<?= $idPoste ?>', this)">Ne plus aimer</button>
                    <?php endif ?>

                    <button class="card-footer-item" onclick="afficherCommenter(this)">Commenter</button>
                <?php endif ?>

                <?php if ($connecte && $sid === $idAuteur) : ?>
                    <button class="card-footer-item" onclick="supprimerPoste('<?= $idPoste ?>', this)">Supprimer</button>
                <?php endif ?>

            </footer>
        </div>

        <div class="commentaire card has-text-centered mt-3">
            <textarea class="commentaire textarea has-fixed-size" placeholder="Commenter ce poste !"></textarea>
            <button class="button is-primary mt-3" onclick="publierCommentaire('<?= $idPoste ?>', this)">Commenter</button>
        </div>

        <div class="lesCommentaires"></div>
    </div>
<?php endforeach ?>