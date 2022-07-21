<?php

switch ($action) {
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
    
    case 'retirerJaimePoste':
        $idPoste = htmlentities($_POST['idPoste']);
        $pdo->retirerJaimePoste($idPoste);
    break;

    case 'ajouterAmi':
        $id = htmlentities($_REQUEST['id']);
        $pdo->ajouterAmi($identifiant, $id);
        $pdo->ajouterAmi($id, $identifiant);
        header("Location:../index.php?action=consulterProfil&id=" . $id);
        exit();
    break;

    case 'retirerAmi':
        $id = htmlentities($_REQUEST['id']);
        $pdo->retirerAmi($identifiant, $id);
        $pdo->retirerAmi($id, $identifiant);
        header("Location:../index.php?action=consulterProfil&id=" . $id);
        exit();
    break;
}