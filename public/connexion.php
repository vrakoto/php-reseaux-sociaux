<?= includeCSS('input') ?>

<div class="form-container">
    <div class="form-card">
        <div class="card-title">
            <h1>Se connecter</h1>
        </div>

        <div class="content">
            <div class="form-control">
                <i class="fas fa-fingerprint"></i>
                <input type="text" class="form-input" id="id" placeholder="Identifiant" autofocus>
            </div>

            <div class="form-control">
                <i class="fas fa-key"></i>
                <input type="password" class="form-input" id="mdp" placeholder="Mot de passe">
            </div>

            <button type="submit" class="btn btn-primary" onclick="verificationConnexion()">Se connecter</button>
        </div>
    </div>
</div>