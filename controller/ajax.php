<?php
$root = dirname(__DIR__) . DIRECTORY_SEPARATOR;
$action = $_REQUEST['c'];
switch ($action) {
    case 'rechercherPoste':
        $type = htmlentities($_GET['type']); 
        $laRecherche = htmlentities($_GET['valeur']);
        $publications = $pdo->rechercherPoste($type, $laRecherche);
        if (count($publications) > 0) {
            require_once $root . 'elements' . DIRECTORY_SEPARATOR . 'publication' . DIRECTORY_SEPARATOR . 'poste.php';
        } else {
            echo "<div class='title is-3 mt-6 has-text-centered'>Aucun résultat pour \"$laRecherche\".</div>";
        }
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

        $pdo->inscrire($id, $nom, $prenom, $mdp, $sexe, $dateNaissance, $ville);
    break;

    case 'connexion':
        $id = htmlentities($_POST['id']);
        $mdp = htmlentities($_POST['mdp']);
        if (!$pdo->verifierConnexion($id, $mdp)) {
            die(header("HTTP/1.0 404 Authentification invalide"));
        }
        $_SESSION['id'] = $id;
    break;

    case 'deconnexion':
        unset($_SESSION['id']);
        header('Location:index.php?action=accueil');
        exit();
    break;



    case 'getLesPostes':
        $publications = $pdo->getLesPostes();
        require_once $root . 'elements' . DIRECTORY_SEPARATOR . 'publication' . DIRECTORY_SEPARATOR . 'poste.php';
    break;

    case 'getLePoste':
        $idPoste = htmlentities($_GET['idPoste']);
        $publications = $pdo->getLePoste($idPoste);
        require_once $root . 'elements' . DIRECTORY_SEPARATOR . 'publication' . DIRECTORY_SEPARATOR . 'poste.php';
    break;

    case 'publierPoste':
        $id = substr(str_shuffle(MD5(microtime())), 0, 20);
        $message = htmlentities($_POST['posteMessage']);

        if (empty(trim($message))) {
            die(header("HTTP/1.0 404 Poste vide"));
        }
        $pdo->publierPoste($id, $message);
    break;
    
    case 'aimerPoste':
        $idPoste = htmlentities($_POST['idPoste']);
        $pdo->aimerPoste($idPoste);
        echo count($pdo->getLesJaimes($idPoste));
    break;

    case 'supprimerPoste':
        $idPoste = htmlentities($_POST['idPoste']);
        $pdo->supprimerPoste($idPoste);
    break;



    case 'getLesCommentaires':
        $idPoste = htmlentities($_GET['idPoste']);
        $lesCommentaires = $pdo->getLesCommentaires($idPoste);
        if (count($lesCommentaires) > 0) {
            require_once $root . 'elements' . DIRECTORY_SEPARATOR . 'publication' . DIRECTORY_SEPARATOR . 'lesCommentaires.php';
        }
    break;

    case 'publierCommentaire':
        $idCommentaire = generateString(20);
        $idPoste = htmlentities($_POST['idPoste']);
        $message = htmlentities($_POST['commentaire']);

        if (empty(trim($message))) {
            die(header("HTTP/1.0 404 Le commentaire est vide"));
        }

        if (mb_strlen($message) > 250) {
            die(header("HTTP/1.0 404 Commentaire trop long (pas plus de 250 caracteres)"));
        }

        $pdo->publierCommentaire($idCommentaire, $idPoste, $message);
        echo count($pdo->getLesCommentaires($idPoste));
    break;

    case 'supprimerCommentaire':
        $idPoste = htmlentities($_POST['idPoste']);
        $idCommentaire = htmlentities($_POST['idCommentaire']);
        $pdo->supprimerCommentaire($idCommentaire);
        echo count($pdo->getLesCommentaires($idPoste));
    break;



    case 'getLesJaimes':
        $idPoste = htmlentities($_GET['idPoste']);
        $lesJaimes = $pdo->getLesJaimes($idPoste);
        if (count($lesJaimes) > 0) {
            require_once $root . 'elements' . DIRECTORY_SEPARATOR . 'publication' . DIRECTORY_SEPARATOR . 'lesJaimes.php';
        } else {
            echo "null";
        }
    break;
    
    case 'retirerJaimePoste':
        $idPoste = htmlentities($_POST['idPoste']);
        $pdo->retirerJaimePoste($idPoste);
    break;
}