<?= includeCSS('input') ?>

<div class="form-container">
    <div class="form-card">
        <div class="card-title">
            <h1>Se connecter</h1>
        </div>

        <div class="content">
            <?= fieldInput('text', 'id', 'fas fa-fingerprint', 'Identifiant', 'autofocus') ?>
            <?= fieldInput('password', 'mdp', 'fas fa-key', 'Mot de passe') ?>

            <div class="has-text-centered mb-3">
                <a href="index.php?action=pageInscription" class="is-size-6 is-underlined">Pas de compte ? Créez-en un !</a>
            </div>

            <button class="btn btn-primary" onclick="verificationConnexion()">Se connecter</button>
        </div>
    </div>
</div>