<?= includeCSS('input') ?>

<div class="form-container" class="mt-4">
    <div class="form-card">
        <div class="card-title">
            <h1>S'inscrire</h1>
        </div>

        <div class="content">
            <p class="help is-danger" id="checkId"></p>
            <div class="form-control">
                <i class="fas fa-fingerprint"></i>
                <input type="text" class="form-input" id="id" placeholder="Identifiant" required autofocus>
            </div>

            <div class="form-control">
                <i class="fas fa-key"></i>
                <input type="password" class="form-input" id="mdp" placeholder="Mot de passe">
            </div>

            <div class="form-control">
                <i class="fas fa-signature"></i>
                <input type="text" class="form-input" id="nom" placeholder="Nom">
            </div>

            <div class="form-control">
                <i class="fas fa-signature"></i>
                <input type="text" class="form-input" id="prenom" placeholder="Prénom">
            </div>

            <div class="form-control">
                <i class="fas fa-venus-mars"></i>
                <select id="sexe" class="form-input">
                    <option value="H">Homme</option>
                    <option value="F">Femme</option>
                </select>
            </div>

            <div class="form-control">
                <i class="fas fa-birthday-cake"></i>
                <input type="date" class="form-input" id="dateNaissance" placeholder="Date de naissance">
            </div>

            <div class="form-control">
                <i class="fas fa-city"></i>
                <input type="text" class="form-input" id="ville" placeholder="Ville">
            </div>

            <button type="submit" class="btn btn-primary" onclick="verificationInscription()">S'inscrire</button>
        </div>
    </div>
</div>