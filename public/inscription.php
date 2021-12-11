<?= includeCSS('input') ?>

<div class="form-container">
    <div class="form-card">
        <div class="card-title">
            <h1>S'inscrire</h1>
        </div>

        <div class="content">
            <?= fieldInput('text', 'id', 'fas fa-fingerprint', 'Identifiant', 'autofocus') ?>
            <?= fieldInput('password', 'mdp', 'fas fa-key', 'Mot de passe') ?>
            <?= fieldInput('text', 'nom', 'fas fa-user', 'Nom') ?>
            <?= fieldInput('text', 'prenom', 'fas fa-user', 'Prénom') ?>
            <?= fieldSelect('sexe', '<option value="H">Homme</option><option value="F">Femme</option>') ?>
            <?= fieldInput('date', 'dateNaissance', 'fas fa-birthday-cake', 'Date de naissance') ?>
            <?= fieldInput('text', 'ville', 'fas fa-city', 'Ville') ?>
            <button type="submit" class="btn btn-primary" onclick="verificationInscription()">S'inscrire</button>
        </div>
    </div>
</div>