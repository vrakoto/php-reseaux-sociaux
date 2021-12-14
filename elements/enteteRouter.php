<?php
session_start();
require_once $root . 'bdd' . DIRECTORY_SEPARATOR . 'Authentification.php';
require_once $root . 'elements' . DIRECTORY_SEPARATOR . 'functions' . DIRECTORY_SEPARATOR . 'helper.php';

$pdo = new Authentification;
$connecte = FALSE;
if ($pdo->connecte()) {
    $connecte = $pdo->connecte();
} else {
    $_SESSION['id'] = null;
}
$sid = $_SESSION['id'];