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
}

require_once 'elements' . DIRECTORY_SEPARATOR . 'footer.php';