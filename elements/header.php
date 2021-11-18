<!DOCTYPE html>
<html lang="en">

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

    <nav class="navbar" role="navigation" aria-label="main navigation">
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

            <div class="navbar-end">
                <div class="navbar-item">
                    <div class="buttons">
                        <?php if (!$connecte): ?>
                            <a href="index.php?action=pageInscription" class="button is-primary">
                                <strong>Inscription</strong>
                            </a>
                            <a href="index.php?action=pageConnexion" class="button is-light">
                                Connexion
                            </a>
                        <?php else: ?>
                            <a href="controller/ajax.php?action=deconnexion" class="button is-danger">
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