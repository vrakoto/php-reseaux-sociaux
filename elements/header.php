<!DOCTYPE html>
<html lang="en" class="has-navbar-fixed-top">

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

    <nav class="navbar is-fixed-top" role="navigation" aria-label="main navigation">
        <div class="navbar-brand">
            <a class="navbar-item is-size-4">
                My Network
            </a>

            <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>

        <div id="navbarBasicExample" class="navbar-menu">
            <div class="navbar-start">
                <a href="index.php?action=accueil" class="navbar-item">
                    Accueil
                </a>
            </div>

            <?php if (strpos($_SERVER['REQUEST_URI'], "accueil")): ?>
                <div class="navbar-item mt-1">
                    <div class="control mr-3">
                        <div class="select">
                            <select id="saisieRecherche">
                                <option value="utilisateur">Rechercher poste par utilisateur</option>
                                <option value="sujet">Rechercher poste par mot-clé</option>
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
                            <a href="index.php?action=pageInscription" class="button is-primary">
                                <strong>Inscription</strong>
                            </a>
                            <a href="index.php?action=pageConnexion" class="button is-light">
                                Connexion
                            </a>
                        <?php else : ?>

                            <div class="dropdown mr-3">
                                <div class="dropdown-trigger">
                                    <button class="button" aria-haspopup="true" aria-controls="dropdown-menu">
                                        <span>Paramètres</span>
                                        <span class="icon is-small">
                                            <i class="fas fa-angle-down" aria-hidden="true"></i>
                                        </span>
                                    </button>
                                </div>
                                <div class="dropdown-menu" id="dropdown-menu" role="menu">
                                    <div class="dropdown-content">
                                        <a class="dropdown-item">
                                            ...
                                        </a>
                                        <a href="#" class="dropdown-item">
                                            Confidentialité
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <a href="index.php?action=ajax&c=deconnexion" class="button is-danger">
                                Déconnexion
                            </a>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="has-text-centered">
        <div class="error-message" style="display: none;"></div>
    </div>

    <div id="modal-msg">
        <div id="modal-content"></div>
    </div>