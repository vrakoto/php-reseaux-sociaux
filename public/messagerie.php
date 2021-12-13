<?= includeCSS('messagerie') ?>

<div class="container messagerie mt-6">
    <div class="is-pulled-left" id="listeContact">
        <input type="text" class="input" id="rechercheAmiConv" placeholder="Rechercher un utilisateur" onkeyup="rechercherAmiConversation()">

        <?php foreach ($lesAmis as $ami) : ?>
            <?php
            $idAmi = htmlentities($ami['idAmi']);
            $avatar = htmlentities($ami['avatar']);
            ?>
            <div class="leContact is-flex is-align-items-center" onclick="getLaConversation('<?= $idAmi ?>', this)">
                <img src="<?= $avatar ?>" alt="Image du contact">
                <p class="leContact-nom"><?= $idAmi ?></p>
            </div>
        <?php endforeach ?>
    </div>

    <div class="is-pulled-right" id="laConversation"></div>
</div>