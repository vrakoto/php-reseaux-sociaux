<?php
session_start();
$root = __DIR__ . DIRECTORY_SEPARATOR;
require_once $root . 'bdd' . DIRECTORY_SEPARATOR . 'Authentification.php';
require_once $root . 'elements' . DIRECTORY_SEPARATOR . 'functions' . DIRECTORY_SEPARATOR . 'helper.php';

$pdo = new Authentification;
$connecte = FALSE;
if ($pdo->connecte()) {
    $connecte = $pdo->connecte();
    $sid = $_SESSION['id'];
}

if (!isset($_REQUEST['action'])) {
    $_REQUEST['action'] = 'accueil';
}

if ($_REQUEST['action'] === 'ajax') {
    // Fichier qui n'inclut pas la partie HTML mais qui sert uniquement d'office au traitement de données.
    require_once $root . 'controller' . DIRECTORY_SEPARATOR . 'ajax.php';
}

require_once $root . 'elements' . DIRECTORY_SEPARATOR . 'header.php';

$action = $_REQUEST['action'];
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
        $lesAmis = $pdo->getLesAmis($idUtilisateur);

        if (empty($pdo->getUtilisateur($idUtilisateur))) {
            echo "Utilisateur inexistant";
            exit();
        }

        if (empty($lesAmis)) {
            echo "Liste vide";
            exit();
        }

        foreach ($lesAmis as $ami) {
            $idAmi = htmlentities($ami['idAmi']);
            $avatar = htmlentities($ami['avatar']);
            $nom = htmlentities($ami['nom']);
            $prenom = htmlentities($ami['prenom']);
            require $root . 'public' . DIRECTORY_SEPARATOR . 'amis.php';
        } 
    break;

    case 'messagerie':
        $lesAmis = $pdo->getLesAmis($sid);
        require_once $root . 'public' . DIRECTORY_SEPARATOR . 'messagerie.php';
    break;
}

require_once 'elements' . DIRECTORY_SEPARATOR . 'footer.php';