<?= includeCSS('preference') ?>

<div id="success" class="container mt-4 has-text-centered has-background-success has-text-white-bis">
    Profil mis-à-jour !
</div>

<div class="container mt-6">
    <header class="tabs-nav">
        <ul>
            <li class="active"><a href="#tab1">Profil</a></li>
            <li><a href="#tab2">Mon Compte</a></li>
        </ul>
    </header>

    <section class="tabs-content">
        <div class="tab" id="tab1">
            <h2 class="title is-4 has-text-centered">Paramètre de visibilité</h2>

            <table class="table">
                <tbody>
                    <tr>
                        <th>Visibilité de mes amis</th>
                        <td>
                            <select id="amisParam">
                                <option value="TOUS" <?php if ($pdo->recupererParametre($sid, "amis") === 'TOUS'): ?>selected<?php endif ?>>Tout le monde</option>
                                <option value="AMIS" <?php if ($pdo->recupererParametre($sid, "amis") === 'AMIS'): ?>selected<?php endif ?>>Uniquement mes amis</option>
                                <option value="PRIVEE" <?php if ($pdo->recupererParametre($sid, "amis") === 'PRIVEE'): ?>selected<?php endif ?>>Privé</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <th>Visibilité de ma biographie</th>
                        <td>
                        <select id="bioParam">
                            <option value="TOUS" <?php if ($pdo->recupererParametre($sid, "biographie") === 'TOUS'): ?>selected<?php endif ?>>Tout le monde</option>
                            <option value="AMIS" <?php if ($pdo->recupererParametre($sid, "biographie") === 'AMIS'): ?>selected<?php endif ?>>Uniquement mes amis</option>
                            <option value="PRIVEE" <?php if ($pdo->recupererParametre($sid, "biographie") === 'PRIVEE'): ?>selected<?php endif ?>>Privé</option>
                        </select>
                        </td>
                    </tr>

                    <tr>
                        <th>Visibilité de mes sujets</th>
                        <td>
                        <select id="sujetParam">
                            <option value="TOUS" <?php if ($pdo->recupererParametre($sid, "sujet") === 'TOUS'): ?>selected<?php endif ?>>Tout le monde</option>
                            <option value="AMIS" <?php if ($pdo->recupererParametre($sid, "sujet") === 'AMIS'): ?>selected<?php endif ?>>Uniquement mes amis</option>
                            <option value="PRIVEE" <?php if ($pdo->recupererParametre($sid, "sujet") === 'PRIVEE'): ?>selected<?php endif ?>>Privé</option>
                        </select>
                        </td>
                    </tr>

                    <tr>
                        <th>Visibilité de mes commentaires</th>
                        <td>
                        <select id="comParam">
                            <option value="TOUS" <?php if ($pdo->recupererParametre($sid, "commentaire") === 'TOUS'): ?>selected<?php endif ?>>Tout le monde</option>
                            <option value="AMIS" <?php if ($pdo->recupererParametre($sid, "commentaire") === 'AMIS'): ?>selected<?php endif ?>>Uniquement mes amis</option>
                            <option value="PRIVEE" <?php if ($pdo->recupererParametre($sid, "commentaire") === 'PRIVEE'): ?>selected<?php endif ?>>Privé</option>
                        </select>
                        </td>
                    </tr>
                </tbody>
            </table>

            <button class="button is-primary mt-3" onclick="profilParams()">Sauvegarder</button>
        </div>

        <div class="tab" id="tab2">
            <h2 class="title is-4 has-text-centered">Paramètre de mon Compte</h2>

            <div class="mb-6">
                <p>Changer photo de profil</p>
                <figure class="image is-128x128">
                    <img class="is-rounded" src="<?= $avatar ?>">
                    <input class="input" type="text" id="lienAvatar" placeholder="http(s)://www....." value="<?= $avatar ?>">
                </figure>
            </div>

            <?= fieldInput("identifiant", "Identifiant", "text", "value='$id' placeholder='Identifiant'") ?>
            <?= fieldInput("mdp", "Changer mot de passe", "password", "placeholder='Mot de passe à changer'") ?>
            <?= fieldInput("mdp_confirm", "Confirmer mot de passe", "password", "placeholder='Confirmer mot de passe'") ?>
            <?= fieldInput("nom", "Nom", "text", "value='$nom' placeholder='Nom'") ?>
            <?= fieldInput("prenom", "Prenom", "text", "value='$prenom' placeholder='Prenom'") ?>
            <?= fieldInput("ville", "Ville", "text", "value='$ville' placeholder='Ville'") ?>

            <br>
            
            <button class="button is-primary mt-3" onclick="compteParams()">Sauvegarder</button>
        </div>
    </section>
</div>