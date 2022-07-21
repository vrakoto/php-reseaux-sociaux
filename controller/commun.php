<?php
switch ($action) {
    case 'accueil':
        $publications = $pdo->getLesPostes();
        require_once PAGES . 'accueil.php';
    break;

    case 'consulterProfil':
        $idUtilisateur = htmlentities($_REQUEST['id']);
        if (!$pdo->verifierIdentifiant($idUtilisateur)) {
            header("Location:index.php?action=accueil");
            exit();
        }

        $leUtilisateur = $pdo->getUtilisateur($idUtilisateur);
        $pasMonProfil = ($connecte && $identifiant !== $idUtilisateur);

        foreach ($leUtilisateur as $utilisateur) {
            $id = htmlentities($utilisateur['id']);
            $avatar = htmlentities($utilisateur['avatar']);
            $nom = htmlentities($utilisateur['nom']);
            $prenom = htmlentities($utilisateur['prenom']);
            $sexe = htmlentities($utilisateur['sexe']);
            $dateNaissance = htmlentities($utilisateur['dateNaissance']);
            $ville = htmlentities($utilisateur['ville']);
            $dateCreation = htmlentities($utilisateur['dateCreation']);
        }

        $publications = $pdo->getLesPostesUtilisateur($id, 3);
        $lesCommentaires = $pdo->getLesCommentairesUtilisateur($id, 5);

        $allowAmis = TRUE;
        $allowBio = TRUE;
        $allowSujet = TRUE;
        $allowCom = TRUE;

        if ($identifiant !== $idUtilisateur) {
            if (!$pdo->autorisationParametre($idUtilisateur, "amis")) {
                $allowAmis = FALSE;
            }
            if (!$pdo->autorisationParametre($idUtilisateur, "biographie")) {
                $allowBio = FALSE;
            }
            if (!$pdo->autorisationParametre($idUtilisateur, "sujet")) {
                $allowSujet = FALSE;
            }
            if (!$pdo->autorisationParametre($idUtilisateur, "commentaire")) {
                $allowCom = FALSE;
            }
        }
        require_once 'public' . DIRECTORY_SEPARATOR . 'profil.php';
    break;

    case 'sujetsUtilisateur':
        $id = htmlentities($_REQUEST['id']);
        $publications = $pdo->getLesPostesUtilisateur($id);
        echo "<div class='container mt-5'>";
        require_once ROOT . 'elements' . DIRECTORY_SEPARATOR . 'publication' . DIRECTORY_SEPARATOR . 'poste.php';
        echo "</div>";
    break;

    case 'commentairesUtilisateur':
        $id = htmlentities($_REQUEST['id']);
        $lesCommentaires = $pdo->getLesCommentairesUtilisateur($id);
        echo "<div class='container mt-5'>";
        require_once ROOT . 'elements' . DIRECTORY_SEPARATOR . 'publication' . DIRECTORY_SEPARATOR . 'lesCommentaires.php';
        echo "</div>";
    break;

    case 'voirLesAmis':
        $idUtilisateur = htmlentities($_REQUEST['id']);

        if (empty($pdo->getUtilisateur($idUtilisateur))) {
            echo "Utilisateur inexistant";
            exit();
        }

        if ($identifiant === $idUtilisateur) {
            $lesAmis = $pdo->getLesAmis($idUtilisateur);
        } else {
            $lesAmis = $pdo->getLesAmis($idUtilisateur, TRUE);
        }

        $nbAmis = (int)count($lesAmis);

        if (empty($lesAmis)) {
            echo "Liste vide";
            exit();
        }

        echo <<<HTML
        <div class="container mt-6">
        <h1 class="title is-5">Les amis de {$idUtilisateur} ({$nbAmis})</h1>
HTML;
        foreach ($lesAmis as $ami) {
            $idAmi = htmlentities($ami['idAmi']);
            $avatar = htmlentities($ami['avatar']);
            $nom = htmlentities($ami['nom']);
            $prenom = htmlentities($ami['prenom']);
            require ROOT . 'public' . DIRECTORY_SEPARATOR . 'amis.php';
        }
        echo "</div>";
    break;
}