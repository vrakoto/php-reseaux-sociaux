<?php
require_once 'elements' . DIRECTORY_SEPARATOR . 'header.php';

if (!isset($_REQUEST['action']))
    $_REQUEST['action'] = 'accueil';

$action = $_REQUEST['action'];

switch ($action) {
    case 'accueil':
        require_once 'public' . DIRECTORY_SEPARATOR . 'accueil.php';
    break;
    
    default:
        # code...
    break;
}

require_once 'elements' . DIRECTORY_SEPARATOR . 'footer.php';