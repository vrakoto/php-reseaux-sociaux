<?php
session_start();
$root = __DIR__ . DIRECTORY_SEPARATOR;
require_once $root . 'bdd' . DIRECTORY_SEPARATOR . 'Authentification.php';
$pdo = new Authentification;
$connecte = FALSE;
if ($pdo->connecte()) {
    $connecte = $pdo->connecte();
    $sid = $_SESSION['id'];
}

require_once $root . 'elements' . DIRECTORY_SEPARATOR . 'functions' . DIRECTORY_SEPARATOR . 'helper.php';
require_once $root . 'elements' . DIRECTORY_SEPARATOR . 'header.php';

if (!isset($_REQUEST['action']))
    $_REQUEST['action'] = 'accueil';

$action = $_REQUEST['action'];

switch ($action) {
    case 'accueil':
        $publications = $pdo->getLesPostes();
        require_once 'public' . DIRECTORY_SEPARATOR . 'accueil.php';
    break;

    case 'pageInscription':
        require_once 'public' . DIRECTORY_SEPARATOR . 'inscription.php';
    break;

    case 'pageConnexion':
        require_once 'public' . DIRECTORY_SEPARATOR . 'connexion.php';
    break;

    case 'consulterProfil':
        $idUtilisateur = htmlentities($_REQUEST['id']);
        $utilisateur = $pdo->getUtilisateur($idUtilisateur);
        
        $id = htmlentities($utilisateur['id']);
        $avatar = htmlentities($utilisateur['avatar']);
        $nom = htmlentities($utilisateur['nom']);
        $prenom = htmlentities($utilisateur['prenom']);
        $sexe = htmlentities($utilisateur['sexe']);
        $dateNaissance = htmlentities($utilisateur['dateNaissance']);
        $ville = htmlentities($utilisateur['ville']);
        $dateCreation = htmlentities($utilisateur['dateCreation']);

        $publications = $pdo->getLesPostesUtilisateur($id);
        require_once 'public' . DIRECTORY_SEPARATOR . 'consulterProfil.php';
    break;
}

require_once 'elements' . DIRECTORY_SEPARATOR . 'footer.php';