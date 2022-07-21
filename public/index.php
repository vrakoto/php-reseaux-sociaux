<?php
$root = __DIR__ . DIRECTORY_SEPARATOR;
require_once $root . 'elements' . DIRECTORY_SEPARATOR . 'enteteRouter.php';

if (!isset($_REQUEST['action'])) {
    header('Location:index.php?action=accueil');
    exit();
}

$action = $_REQUEST['action'];
switch ($action) { // PARTIE AJAX
    case 'rechercherPoste':
        $type = htmlentities($_GET['type']); 
        $laRecherche = htmlentities($_GET['valeur']);
        $publications = $pdo->rechercherPoste($type, $laRecherche);
        
        if (count($publications) > 0) {
            require_once $root . 'elements' . DIRECTORY_SEPARATOR . 'publication' . DIRECTORY_SEPARATOR . 'poste.php';
        } else {
            echo "<div class='title is-3 mt-6 has-text-centered'>Aucun résultat pour \"$laRecherche\".</div>";
        }
        exit();
    break;

    case 'inscription':
        $id = htmlentities($_POST['identifiant']);
        $nom = htmlentities($_POST['nom']);
        $prenom = htmlentities($_POST['prenom']);
        $mdp = htmlentities($_POST['mdp']);
        $sexe = htmlentities($_POST['sexe']);
        $dateNaissance = htmlentities($_POST['dateNaissance']);
        $ville = htmlentities($_POST['ville']);

        $erreurs = [];

        if ($pdo->verifierIdentifiant($id)) {
            $erreurs['id'] = 'Identifiant déjà prit';
        }

        if (strlen($id) < 2) {
            $erreurs['id'] = 'Identifiant trop court';
        }

        if (strlen($nom) < 2) {
            $erreurs['nom'] = 'Nom trop court';
        }

        if (strlen($prenom) < 2) {
            $erreurs['prenom'] = 'Prénom trop court';
        }

        if (strlen($mdp) < 2) {
            $erreurs['mdp'] = 'Mot de passe trop court';
        }

        if ($sexe !== 'H' && $sexe !== 'F') {
            $erreurs['sexe'] = 'Sexe invalide';
        }

        $currentDate = date("Y-m-d");
        if ($dateNaissance === '' || $dateNaissance > $currentDate) {
            $erreurs['dateNaissance'] = 'Date de naissance incorrect';
        }

        if (strlen($ville) < 2) {
            $erreurs['ville'] = 'Ville trop courte';
        }

        if (!empty($erreurs)) {
            header("HTTP/1.0 400 Le formulaire est incorrect :");
            die(json_encode($erreurs));
        }

        $mdpHash = password_hash($mdp, PASSWORD_DEFAULT, ['cost' => 12]);
        $pdo->inscrire($id, $nom, $prenom, $mdpHash, $sexe, $dateNaissance, $ville);
        $pdo->creerParametre($id);
        exit();
    break;

    case 'connexion':
        $id = htmlentities($_POST['id']);
        $mdp = htmlentities($_POST['mdp']);
        if (!$pdo->verifierIdentifiant($id) || !password_verify($mdp, $pdo->getUtilisateur($id)[0]['mdp'])) {
            die(header("HTTP/1.0 404 Authentification invalide"));
        }
        $_SESSION['id'] = $id;
        exit();
    break;

    case 'getLesPostes':
        $publications = $pdo->getLesPostes();
        require_once $root . 'elements' . DIRECTORY_SEPARATOR . 'publication' . DIRECTORY_SEPARATOR . 'poste.php';
        exit();
    break;

    case 'getLePoste':
        $idPoste = htmlentities($_GET['idPoste']);
        $publications = $pdo->getLePoste($idPoste);
        require_once $root . 'elements' . DIRECTORY_SEPARATOR . 'publication' . DIRECTORY_SEPARATOR . 'poste.php';
        exit();
    break;

    case 'getLesCommentaires':
        $idPoste = htmlentities($_GET['idPoste']);
        $lesCommentaires = $pdo->getLesCommentaires($idPoste);
        if (count($lesCommentaires) > 0) {
            require_once $root . 'elements' . DIRECTORY_SEPARATOR . 'publication' . DIRECTORY_SEPARATOR . 'lesCommentaires.php';
        }
        exit();
    break;

    case 'getLesJaimes':
        $idPoste = htmlentities($_GET['idPoste']);
        $lesJaimes = $pdo->getLesJaimes($idPoste);
        if (count($lesJaimes) > 0) {
            require_once $root . 'elements' . DIRECTORY_SEPARATOR . 'publication' . DIRECTORY_SEPARATOR . 'lesJaimes.php';
        } else {
            echo "null";
        }
        exit();
    break;
}

require_once $root . 'elements' . DIRECTORY_SEPARATOR . 'header.php';

switch ($action) {
    case 'accueil':
        $publications = $pdo->getLesPostes();
        require_once $root . 'public' . DIRECTORY_SEPARATOR . 'accueil.php';
    break;

    case 'pageInscription':
        if ($connecte) {
            header('Location:index.php?action=accueil');
            exit();
        }
        require_once $root . 'public' . DIRECTORY_SEPARATOR . 'inscription.php';
    break;

    case 'pageConnexion':
        if ($connecte) {
            header('Location:index.php?action=accueil');
            exit();
        }
        require_once $root . 'public' . DIRECTORY_SEPARATOR . 'connexion.php';
    break;

    case 'consulterProfil':
        $idUtilisateur = htmlentities($_REQUEST['id']);
        if (!$pdo->verifierIdentifiant($idUtilisateur)) {
            header("Location:index.php?action=accueil");
            exit();
        }

        $leUtilisateur = $pdo->getUtilisateur($idUtilisateur);
        $pasMonProfil = ($connecte && $sid !== $idUtilisateur);

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

        if ($sid !== $idUtilisateur) {
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
        require_once $root . 'elements' . DIRECTORY_SEPARATOR . 'publication' . DIRECTORY_SEPARATOR . 'poste.php';
        echo "</div>";
    break;

    case 'commentairesUtilisateur':
        $id = htmlentities($_REQUEST['id']);
        $lesCommentaires = $pdo->getLesCommentairesUtilisateur($id);
        echo "<div class='container mt-5'>";
        require_once $root . 'elements' . DIRECTORY_SEPARATOR . 'publication' . DIRECTORY_SEPARATOR . 'lesCommentaires.php';
        echo "</div>";
    break;

    case 'voirLesAmis':
        $idUtilisateur = htmlentities($_REQUEST['id']);

        if (empty($pdo->getUtilisateur($idUtilisateur))) {
            echo "Utilisateur inexistant";
            exit();
        }

        if ($sid === $idUtilisateur) {
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
            require $root . 'public' . DIRECTORY_SEPARATOR . 'amis.php';
        }
        echo "</div>";
    break;

    case 'messagerie':
        $lesAmis = $pdo->getLesAmis($sid);
        require_once $root . 'public' . DIRECTORY_SEPARATOR . 'messagerie.php';
    break;

    case 'preference':
        $utilisateur = $pdo->getUtilisateur($sid)[0];
        $id = htmlentities($utilisateur['id']);
        $avatar = htmlentities($utilisateur['avatar']);
        $nom = htmlentities($utilisateur['nom']);
        $prenom = htmlentities($utilisateur['prenom']);
        $mdp = htmlentities($utilisateur['mdp']);
        $ville = htmlentities($utilisateur['ville']);

        require_once $root . 'public' . DIRECTORY_SEPARATOR . 'preference.php';
    break;
}

require_once 'elements' . DIRECTORY_SEPARATOR . 'footer.php';