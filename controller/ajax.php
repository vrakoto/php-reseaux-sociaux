<?php
session_start();
// Fichier qui n'inclut pas la partie HTML mais qui sert uniquement d'office au traitement  de données.
$root = dirname(__DIR__) . DIRECTORY_SEPARATOR;
require_once $root . 'bdd' . DIRECTORY_SEPARATOR . 'Authentification.php';
$pdo = new Authentification;
require_once $root . 'elements' . DIRECTORY_SEPARATOR . 'functions' . DIRECTORY_SEPARATOR . 'helper.php';

$connecte = FALSE;
if ($pdo->connecte()) {
    $sid = $_SESSION['id'];
    $connecte = $pdo->connecte();
}

$action = $_REQUEST['action'];
switch ($action) {
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
        header('Location:../index.php?action=accueil');
        exit();
    break;

    case 'getLesPostes':
        $publications = $pdo->getLesPostes();
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

    case 'publierCommentaire':
        $idPoste = htmlentities($_POST['idPoste']);
        $message = htmlentities($_POST['commentaire']);

        if (empty(trim($message))) {
            die(header("HTTP/1.0 404 Le commentaire est vide"));
        }

        if (mb_strlen($message) > 250) {
            die(header("HTTP/1.0 404 Commentaire trop long (pas plus de 250 caracteres)"));
        }

        $pdo->publierCommentaire($idPoste, $message);
    break;

    case 'afficherLesCommentaires':
        $idPoste = htmlentities($_GET['idPoste']);
        $lesCommentaires = $pdo->getLesCommentaires($idPoste);
        require_once $root . 'elements' . DIRECTORY_SEPARATOR . 'publication' . DIRECTORY_SEPARATOR . 'lesCommentaires.php';
    break;

    case 'afficherLesJaimes':
        $idPoste = htmlentities($_GET['idPoste']);
        $lesJaimes = $pdo->getLesJaimes($idPoste);
        require_once $root . 'elements' . DIRECTORY_SEPARATOR . 'publication' . DIRECTORY_SEPARATOR . 'lesJaimes.php';
    break;
    
    case 'aimerPoste':
        $idPoste = htmlentities($_POST['idPoste']);
        $pdo->aimerPoste($idPoste);
    break;

    case 'retirerJaime':
        $idPoste = htmlentities($_POST['idPoste']);
        $pdo->retirerJaime($idPoste);
    break;

    case 'supprimerPoste':
        $idPoste = htmlentities($_POST['idPoste']);
        $pdo->supprimerPoste($idPoste);
    break;
}