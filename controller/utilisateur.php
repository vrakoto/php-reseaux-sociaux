<?php
$action = $_REQUEST['u'];
switch ($action) {
    case 'deconnexion':
        unset($_SESSION['id']);
        header('Location:../index.php?action=accueil');
    break;

    /* case 'getLaConversation':
        $idAmi = htmlentities($_GET['idAmi']);
        if (empty($pdo->getUtilisateur($idAmi))) {
            die(header("HTTP/1.0 404 Utilisateur inexistant"));
        }

        $laConversation = $pdo->getLaConversation($idAmi);
        foreach ($laConversation as $conversation) {
            $idAmi = htmlentities($conversation['idAmi']);
            $avatar = htmlentities($conversation['avatar']);
            $nom = htmlentities($conversation['nom']);
            $prenom = htmlentities($conversation['prenom']);
            $message = nl2br(htmlentities($conversation['message']));
            $dateInit = htmlentities($conversation['dateEnvoie']);
            $date = date('d-m-Y à H:m', strtotime($dateInit));

            $estAuteur = $identifiant === $idAmi ? TRUE : FALSE;
            require ROOT . 'elements' . DIRECTORY_SEPARATOR . 'publication' . DIRECTORY_SEPARATOR . 'conversation.php';
        }
        echo <<<HTML
        <div id="envoie">
            <textarea class="textarea has-fixed-size mb-3" id="message" placeholder="Ecrire un message"></textarea>
            <div class="file has-name is-right is-inline-block">
                <label class="file-label">
                    <input class="file-input" type="file" id="image">
                    <span class="file-cta">
                    <span class="file-icon">
                        <i class="fas fa-upload"></i>
                    </span>
                    <span class="file-label">
                        Insérer une image
                    </span>
                    </span>
                </label>
            </div>
            <button class="button is-primary is-pulled-right" onclick="envoyerMessage()">Envoyer</button>
        </div>
HTML;
    break;


    case 'envoyerMessage':
        $idAmi = htmlentities($_POST['idAmi']);
        $message = htmlentities($_POST['message']);

        if (empty($pdo->getUtilisateur($idAmi))) {
            die(header("HTTP/1.0 404 Utilisateur inexistant"));
        }

        if (mb_strlen($message) < 1) {
            die(header("HTTP/1.0 404 Message trop court"));
        }
        $pdo->envoyerMessage($idAmi, $message);
    break; */

    case 'parametreProfil':
        if (isset($_POST['amis'], $_POST['bio'], $_POST['sujet'], $_POST['commentaire'])) {
            $amisParam = htmlentities($_POST['amis']);
            $bioParam = htmlentities($_POST['bio']);
            $sujetParam = htmlentities($_POST['sujet']);
            $commentaireParam = htmlentities($_POST['commentaire']);

            $pdo->updateProfil($amisParam, $bioParam, $sujetParam, $commentaireParam);
        }
    break;

    case 'parametreCompte':
        if (isset($_POST['mdp'], $_POST['mdp_confirm'], $_POST['nom'], $_POST['prenom'], $_POST['ville'])) {
            $avatar = htmlentities($_POST['lienAvatar']);
            $mdp = htmlentities($_POST['mdp']);
            $mdp_confirm = htmlentities($_POST['mdp_confirm']);
            $nom = htmlentities($_POST['nom']);
            $prenom = htmlentities($_POST['prenom']);
            $ville = htmlentities($_POST['ville']);

            if (strlen($avatar) < 10) {
                die(header("HTTP/1.0 404 Lien de l'avatar incorrect"));
            }

            if (!empty($mdp)) {
                if (strlen($mdp) < 2) {
                    die(header("HTTP/1.0 404 Mot de passe trop court"));
                }

                if ($mdp !== $mdp_confirm) {
                    die(header("HTTP/1.0 404 Les mots de passe ne correspondent pas"));
                }
            } else {
                $mdp = $pdo->getUtilisateur($identifiant)[0]['mdp'];
            }

            if (strlen($nom) < 2) {
                die(header("HTTP/1.0 404 Nom trop court"));
            }

            if (strlen($prenom) < 2) {
                die(header("HTTP/1.0 404 Prenom trop court"));
            }

            if (strlen($ville) < 2) {
                die(header("HTTP/1.0 404 Nom de la ville trop courte"));
            }

            $mdpHash = password_hash($mdp, PASSWORD_DEFAULT, ['cost' => 12]);

            $pdo->updateCompte($avatar, $identifiant, $mdpHash, $nom, $prenom, ucfirst($ville));
        }
    break;

    case 'preference':
        $utilisateur = $pdo->getUtilisateur($identifiant)[0];
        $id = htmlentities($utilisateur['id']);
        $avatar = htmlentities($utilisateur['avatar']);
        $nom = htmlentities($utilisateur['nom']);
        $prenom = htmlentities($utilisateur['prenom']);
        $mdp = htmlentities($utilisateur['mdp']);
        $ville = htmlentities($utilisateur['ville']);

        require_once ROOT . 'public' . DIRECTORY_SEPARATOR . 'preference.php';
    break;

    /* case 'messagerie':
        $lesAmis = $pdo->getLesAmis($identifiant);
        require_once ROOT . 'public' . DIRECTORY_SEPARATOR . 'messagerie.php';
    break; */
}