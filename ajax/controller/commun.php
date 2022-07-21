<?php
switch ($action) {
    case 'rechercherPoste':
        $type = htmlentities($_GET['type']); 
        $laRecherche = htmlentities($_GET['valeur']);
        $publications = $pdo->rechercherPoste($type, $laRecherche);
        
        if (count($publications) > 0) {
            require_once ROOT . 'elements' . DIRECTORY_SEPARATOR . 'publication' . DIRECTORY_SEPARATOR . 'poste.php';
        } else {
            echo "<div class='title is-3 mt-6 has-text-centered'>Aucun résultat pour \"$laRecherche\".</div>";
        }
    break;

    case 'getLesPostes':
        $publications = $pdo->getLesPostes();
        require_once ROOT . 'elements' . DIRECTORY_SEPARATOR . 'publication' . DIRECTORY_SEPARATOR . 'poste.php';
        exit();
    break;

    case 'getLePoste':
        $idPoste = htmlentities($_GET['idPoste']);
        $publications = $pdo->getLePoste($idPoste);
        require_once ROOT . 'elements' . DIRECTORY_SEPARATOR . 'publication' . DIRECTORY_SEPARATOR . 'poste.php';
        exit();
    break;

    case 'getLesCommentaires':
        $idPoste = htmlentities($_GET['idPoste']);
        $lesCommentaires = $pdo->getLesCommentaires($idPoste);
        if (count($lesCommentaires) > 0) {
            require_once ROOT . 'elements' . DIRECTORY_SEPARATOR . 'publication' . DIRECTORY_SEPARATOR . 'lesCommentaires.php';
        }
        exit();
    break;

    case 'getLesJaimes':
        $idPoste = htmlentities($_GET['idPoste']);
        $lesJaimes = $pdo->getLesJaimes($idPoste);
        if (count($lesJaimes) > 0) {
            require_once ROOT . 'elements' . DIRECTORY_SEPARATOR . 'publication' . DIRECTORY_SEPARATOR . 'lesJaimes.php';
        } else {
            echo "null";
        }
        exit();
    break;
}