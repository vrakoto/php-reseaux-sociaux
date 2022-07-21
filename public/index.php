<?php
session_start();

define("ROOT", dirname(__DIR__) . DIRECTORY_SEPARATOR);
define("AJAX_CONTROLLER", ROOT . 'ajax' . DIRECTORY_SEPARATOR . 'controller' . DIRECTORY_SEPARATOR);
define("AJAX_PAGES", ROOT . 'ajax' . DIRECTORY_SEPARATOR . 'pages' . DIRECTORY_SEPARATOR);

define("CONTROLLER", ROOT . 'controller' . DIRECTORY_SEPARATOR);
define("MODELS", ROOT . 'models' . DIRECTORY_SEPARATOR);
define("PAGES", ROOT . 'pages' . DIRECTORY_SEPARATOR);
define("ELEMENTS", ROOT . 'elements' .  DIRECTORY_SEPARATOR);
define("FONCTIONS", ROOT . 'fonctions' .  DIRECTORY_SEPARATOR);

define("PUBLIC_FOLDER", ROOT . 'public' . DIRECTORY_SEPARATOR);
define("JS", PUBLIC_FOLDER . 'JS' . DIRECTORY_SEPARATOR);
define("CSS", PUBLIC_FOLDER . 'CSS' . DIRECTORY_SEPARATOR);
define("FONTAWESOME", CSS . 'fontawesome' . DIRECTORY_SEPARATOR . 'all.min.css');
define("BOOTSTRAP", CSS . 'bootstrap' . DIRECTORY_SEPARATOR . 'bootstrap.min.css');

require_once MODELS . 'Commun.php';
require_once FONCTIONS . 'helper.php';

if (!isset($_REQUEST['action'])) {
    header('Location:index.php?action=accueil');
    exit();
}
$action = $_REQUEST['action'];

$pdo = new Commun;
$connecte = $pdo->estConnecte();
if ($connecte) {
    $identifiant = $_SESSION['id'];
    require_once MODELS . 'Utilisateur.php';
} else {
    $identifiant = '';
    require_once MODELS . 'Visiteur.php';
}

if ($action === 'ajax') {
    require_once AJAX_CONTROLLER . 'commun.php';
}

ob_start();
if ($connecte) {
    require_once CONTROLLER . 'utilisateur.php';
} else {
    require_once CONTROLLER . 'visiteur.php';
}
require_once CONTROLLER . 'commun.php';
$content = ob_get_clean();

require_once ELEMENTS . 'layout.php';