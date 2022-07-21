<div class="card mb-4">
    <div class="card-content">
        <div class="media">
            <div class="media-left">
                <figure class="image is-48x48">
                    <img src="<?= $avatar ?>" alt="Avatar de l'ami">
                </figure>
            </div>
            <div class="media-content">
                <p class="title is-4 mb-0"><?= $prenom . ' ' . $nom ?></p>
                <a href="index.php?action=consulterProfil&id=<?= $idAmi ?>" class="subtitle is-6 is-underlined">@<?= $idAmi ?></a>
            </div>
        </div>
    </div>
</div>