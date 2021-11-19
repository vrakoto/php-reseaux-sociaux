<h1>Bienvenu <?= $sid ?? '' ?> !</h1>

<div id="modal-msg">
    <div id="modal-content"></div>
</div>

<div class="container">
    <?php if ($connecte) : ?>
        <div class="has-text-centered mt-5">
            <textarea class="textarea" id="posteMessage" placeholder="Exprimez votre humeur !"></textarea>
            <button class="button is-primary mt-3" onclick="publierPoste()">Publier</button>
        </div>
    <?php endif ?>

    <div id="postes"></div>
</div>