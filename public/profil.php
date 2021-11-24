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
                        <a href="index.php?action=ajax&c=ajouterAmi&id=<?= $id ?>" class="card-footer-item">Ajouter en Ami</a>
                    <?php else: ?>
                        <a href="index.php?action=ajax&c=retirerAmi&id=<?= $id ?>" class="card-footer-item">Retirer Ami</a>
                    <?php endif ?>
                <?php endif ?>
                
                <a href="index.php?action=voirLesAmis&id=<?= $id ?>" class="card-footer-item">Amis</a>
            </div>

            <p class="title is-5 mb-2 mt-6">A propos de moi</p>
            <div class="card bg-green">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Neque voluptatem amet voluptatum maxime natus esse, distinctio laborum autem iure consequuntur consectetur expedita reprehenderit, laboriosam vel tempore similique magnam labore aut!
            </div>

            <div class="is-flex is-justify-content-space-between bigSpace">
                <p class="title is-5">Sujet(s) récent</p>
                <a href="index.php?action=sujetsUtilisateur&id=<?= $id ?>" class="is-underlined">Tous montrer</a>
            </div>

            <?php require_once $root . 'elements' . DIRECTORY_SEPARATOR . 'publication' . DIRECTORY_SEPARATOR . 'poste.php' ?>

            <div class="is-flex is-justify-content-space-between bigSpace">
                <p class="title is-5">Commentaire(s) récent</p>
                <a href="index.php?action=commentairesUtilisateur&id=<?= $id ?>" class="is-underlined">Tous montrer</a>
            </div>

            <div class="commentaireUtilisateurRecent">
                <?php require_once $root . 'elements' . DIRECTORY_SEPARATOR . 'publication' . DIRECTORY_SEPARATOR . 'lesCommentaires.php' ?>
            </div>
        </div>
    </div>
</div>