<!DOCTYPE html>
<html lang="en" class="has-navbar-fixed-top has-background-light">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ma page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.3/css/bulma.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <?= includeCSS('basic') ?>
</head>

<body>
    
    <nav class="navbar is-fixed-top fullhd is-dark" role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
            <a class="navbar-item is-size-4">
                <?= $sid ?? 'My Network' ?>
            </a>

            <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>

        <div class="navbar-menu">
            <div class="navbar-start">

                <?= nav_item('index.php?action=accueil', 'Accueil') ?>

                <?php if ($connecte): ?>
                    <?= nav_item("index.php?action=consulterProfil&id=$sid", 'Mon Profil') ?>
                <?php endif ?>

            </div>

            <?php if (strpos($_SERVER['REQUEST_URI'], "accueil")) : ?>
                <div class="navbar-item mt-1">
                    <div class="control mr-3">
                        <div class="select">
                            <select id="saisieRecherche">
                                <option value="sujet">Rechercher poste par mot-clé</option>
                                <option value="utilisateur">Rechercher poste par utilisateur</option>
                            </select>
                        </div>
                    </div>

                    <div class="field is-grouped">
                        <p class="control is-expanded">
                            <input class="input" type="text" id="rechercher" placeholder="Rechercher ...">
                        </p>
                        <p class="control">
                            <button class="button is-info" onclick="rechercherPoste($('#saisieRecherche').val(), $('#rechercher').val())">Rechercher</button>
                        </p>
                    </div>
                </div>
            <?php endif ?>

            <div class="navbar-end">
                <div class="navbar-item">
                    <div class="buttons">
                        <?php if (!$connecte) : ?>
                            <a href="index.php?action=pageConnexion" class="button is-primary">
                                Connexion
                            </a>
                        <?php else : ?>

                            <a href="index.php?action=voirLesAmis&id=<?= $sid ?>" class="button">
                                <span class="icon"><i class="fas fa-user-friends" aria-hidden="true"></i></span>
                                <span>Voir mes amis</span>
                            </a>

                            <a href="index.php?action=messagerie" class="button">
                                <span class="icon"><i class="fas fa-envelope" aria-hidden="true"></i></span>
                                <span>Messagerie</span>
                            </a>

                            <div class="dropdown mr-3">
                                <div class="dropdown-trigger">
                                    <button class="button" aria-haspopup="true" aria-controls="dropdown-menu">
                                        <span class="icon"><i class="fas fa-cog"></i></span>

                                        <span>Paramètres</span>
                                        <span class="icon is-small">
                                            <i class="fas fa-angle-down" aria-hidden="true"></i>
                                        </span>
                                    </button>
                                </div>
                                <div class="dropdown-menu" id="dropdown-menu" role="menu">
                                    <div class="dropdown-content">
                                        <a href="index.php?action=preference" class="dropdown-item">Préférence</a>
                                        <a href="#" class="dropdown-item">
                                            Confidentialité
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <a href="controller/utilisateur.php?u=deconnexion" class="button is-danger">
                                Déconnexion
                            </a>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="container has-text-centered">
        <div class="messageStatic"></div>
    </div>

    <div id="popupScreen">
        <div id="popupContent"></div>
    </div>