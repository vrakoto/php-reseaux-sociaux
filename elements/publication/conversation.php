<?php if ($estAuteur) : ?>
    <div class="friend">
        <img src="<?= $avatar ?>" alt="Avatar de l'utilisateur">
        <p><?= $message ?></p>
    </div>
    <!-- <p><?= $date ?></p> -->
<?php else : ?>
    <div class="user">
        <p><?= $message ?></p>
        <!-- <p class="date"><?= $date ?></p> -->
    </div>
<?php endif ?>