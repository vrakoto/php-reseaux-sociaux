<?= includeCSS('profil') ?>

<div class="container mt-5">
    <div class="card">
        <div class="card-content">
            <div class="media">
                <div class="media-left">
                    <figure class="image is-48x48">
                        <img src="<?= $avatar ?>" alt="Avatar de l'utilisateur">
                    </figure>
                </div>
                <div class="media-content">
                    <p class="subtitle is-6">@<?= $id ?></p>
                    <p class="title is-4 mb-0"><?= $prenom . ' ' . $nom ?></p>
                </div>
            </div>

            <div class="is-flex mb-5">
                <?php if ($pasMonProfil): ?>
                    <?php if (!$pdo->estMonAmi($id)): ?>
                        <a href="controller/utilisateur.php?u=ajouterAmi&id=<?= $id ?>" class="card-footer-item">Ajouter en Ami</a>
                    <?php else: ?>
                        <a href="controller/utilisateur.php?u=retirerAmi&id=<?= $id ?>" class="card-footer-item">Retirer Ami</a>
                    <?php endif ?>
                <?php endif ?>
                
                <?php if ($allowAmis): ?>
                    <a href="index.php?action=voirLesAmis&id=<?= $id ?>" class="card-footer-item">Amis</a>
                <?php endif ?>
            </div>

            <?php if ($allowBio): ?>
                <p class="title is-5 mb-2 mt-6">A propos de moi</p>
                <div class="card bg-green">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Neque voluptatem amet voluptatum maxime natus esse, distinctio laborum autem iure consequuntur consectetur expedita reprehenderit, laboriosam vel tempore similique magnam labore aut!
                </div>
            <?php endif ?>

            <?php if ($allowSujet): ?>
                <div class="is-flex is-justify-content-space-between bigSpace">
                    <p class="title is-5">Sujet(s) récent</p>
                    <a href="index.php?action=sujetsUtilisateur&id=<?= $id ?>" class="is-underlined">Tous montrer</a>
                </div>
                <?php require_once ROOT . 'elements' . DIRECTORY_SEPARATOR . 'publication' . DIRECTORY_SEPARATOR . 'poste.php' ?>
            <?php endif ?>

            <?php if ($allowCom): ?>
                <div class="is-flex is-justify-content-space-between bigSpace">
                    <p class="title is-5">Commentaire(s) récent</p>
                    <a href="index.php?action=commentairesUtilisateur&id=<?= $id ?>" class="is-underlined">Tous montrer</a>
                </div>

                <div class="commentaireUtilisateurRecent">
                    <?php require_once ROOT . 'elements' . DIRECTORY_SEPARATOR . 'publication' . DIRECTORY_SEPARATOR . 'lesCommentaires.php' ?>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>