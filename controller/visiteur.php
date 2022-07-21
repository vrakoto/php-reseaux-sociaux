<?php

switch ($action) {
    case 'pageInscription':
        if ($connecte) {
            header('Location:index.php?action=accueil');
            exit();
        }
        require_once ROOT . 'public' . DIRECTORY_SEPARATOR . 'inscription.php';
    break;

    case 'pageConnexion':
        if ($connecte) {
            header('Location:index.php?action=accueil');
            exit();
        }
        require_once ROOT . 'public' . DIRECTORY_SEPARATOR . 'connexion.php';
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

        $mdpHash = password_hash($mdp, PASSWORD_DEFAULT, ['cost' => 12]);
        $pdo->inscrire($id, $nom, $prenom, $mdpHash, $sexe, $dateNaissance, $ville);
        $pdo->creerParametre($id);
        exit();
    break;

    case 'connexion':
        $id = htmlentities($_POST['id']);
        $mdp = htmlentities($_POST['mdp']);
        if (!$pdo->verifierIdentifiant($id) || !password_verify($mdp, $pdo->getUtilisateur($id)[0]['mdp'])) {
            die(header("HTTP/1.0 404 Authentification invalide"));
        }
        $_SESSION['id'] = $id;
    break;
}