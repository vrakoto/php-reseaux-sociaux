<?php

class Utilisateur extends Commun {
    public function __construct()
    {
        parent::__construct();
    }

    function publierPoste(string $id, string $message): PDOStatement
    {
        $req = "INSERT INTO poste (id, auteur, message) VALUES (:id, :auteur, :message)";

        $p = $this->pdo->prepare($req);
        $p->execute([
            'id' => $id,
            'auteur' => $_SESSION['id'],
            'message' => $message
        ]);
        return $p;
    }

    function aimerPoste(string $idPoste): PDOStatement
    {
        $req = "INSERT INTO poste_aimer (idPoste, auteur) VALUES (:idPoste, :auteur)";
        $p = $this->pdo->prepare($req);
        $p->execute([
            'idPoste' => $idPoste,
            'auteur' => $_SESSION['id']
        ]);

        return $p;
    }

    

    function supprimerPoste(string $idPoste): PDOStatement
    {
        $req = "DELETE FROM poste WHERE id = :idPoste AND auteur = :auteur";
        $p = $this->pdo->prepare($req);
        $p->execute([
            'idPoste' => $idPoste,
            'auteur' => $_SESSION['id']
        ]);

        return $p;
    }

    function publierCommentaire(string $idCommentaire, string $idPoste, string $message): PDOStatement
    {
        $req = "INSERT INTO commentaire (id, idPoste, auteur, message) VALUES (:idCommentaire, :idPoste, :auteur, :message)";

        $p = $this->pdo->prepare($req);
        $p->execute([
            'idCommentaire' => $idCommentaire,
            'idPoste' => $idPoste,
            'auteur' => $_SESSION['id'],
            'message' => $message
        ]);
        return $p;
    }

    function supprimerCommentaire(string $idCommentaire): PDOStatement
    {
        $req = "DELETE FROM commentaire WHERE id = :idCommentaire AND auteur = :auteur";
        $p = $this->pdo->prepare($req);
        $p->execute([
            'idCommentaire' => $idCommentaire,
            'auteur' => $_SESSION['id']
        ]);

        return $p;
    }

    function retirerJaimePoste(string $idPoste): PDOStatement
    {
        $req = "DELETE FROM poste_aimer WHERE idPoste = :idPoste AND auteur = :auteur";
        $p = $this->pdo->prepare($req);
        $p->execute([
            'idPoste' => $idPoste,
            'auteur' => $_SESSION['id']
        ]);

        return $p;
    }


    function ajouterAmi(string $idAmi1, string $idAmi2): PDOStatement
    {
        $req = "INSERT INTO amis (idAmi, idUtilisateur) VALUES (:idAmi, :idUtilisateur)";
        $p = $this->pdo->prepare($req);
        $p->execute([
            'idUtilisateur' => $idAmi1,
            'idAmi' => $idAmi2
        ]);

        return $p;
    }

    function estMonAmi(string $idAmi): bool
    {
        $req = "SELECT idAmi FROM amis WHERE idUtilisateur = :idUtilisateur AND idAmi = :idAmi";
        $p = $this->pdo->prepare($req);
        $p->execute([
            'idUtilisateur' => $_SESSION['id'],
            'idAmi' => $idAmi
        ]);

        return !empty($p->fetch());
    }

    function retirerAmi(string $idAmi1, string $idAmi2): PDOStatement
    {
        $req = "DELETE FROM amis WHERE idUtilisateur = :idUtilisateur AND idAmi = :idAmi";
        $p = $this->pdo->prepare($req);
        $p->execute([
            'idUtilisateur' => $idAmi1,
            'idAmi' => $idAmi2
        ]);

        return $p;
    }


    function envoyerMessage(string $idAmi, string $message): PDOStatement
    {
        $req = "INSERT INTO conversation (idUtilisateur, idAmi, message) VALUES (:idUtilisateur, :idAmi, :message)";
        $p = $this->pdo->prepare($req);
        $p->execute([
            'idUtilisateur' => $_SESSION['id'],
            'idAmi' => $idAmi,
            'message' => $message
        ]);

        return $p;
    }

    function getLaConversation(string $idAmi): array
    {
        $req = "SELECT idAmi, message, dateEnvoie, avatar, nom, prenom
                FROM conversation c JOIN utilisateur u on c.idAmi = u.id
                WHERE (idUtilisateur = :idUtilisateur AND idAmi = :idAmi)
                OR (idUtilisateur = :idAmi AND idAmi = :idUtilisateur)";
        $p = $this->pdo->prepare($req);
        $p->execute([
            'idUtilisateur' => $_SESSION['id'],
            'idAmi' => $idAmi,
        ]);

        $conversation = $p->fetchAll();
        return $conversation;
    }



    function creerParametre(string $id): PDOStatement
    {
        $req = "INSERT INTO parametre (idUtilisateur) VALUES (:idUtilisateur)";
        $p = $this->pdo->prepare($req);
        $p->execute([
            'idUtilisateur' => $id
        ]);

        return $p;
    }

    function updateProfil(string $amisParam, string $bioParam, string $sujetParam, string $commentaireParam): PDOStatement
    {
        $req = "UPDATE parametre SET amis = :amis, biographie = :biographie, sujet = :sujet, commentaire = :commentaire WHERE idUtilisateur = :idUtilisateur";
        $p = $this->pdo->prepare($req);
        $p->execute([
            'amis' => $amisParam,
            'biographie' => $bioParam,
            'sujet' => $sujetParam,
            'commentaire' => $commentaireParam,
            'idUtilisateur' => $_SESSION['id']
        ]);

        return $p;
    }

    function updateCompte(string $avatar, string $id, string $mdp, string $nom, string $prenom, string $ville): PDOStatement
    {
        $req = "UPDATE utilisateur SET avatar = :avatar, id = :id, mdp = :mdp, nom = :nom, prenom = :prenom, ville = :ville WHERE id = :id";
        $p = $this->pdo->prepare($req);
        $p->execute([
            'avatar' => $avatar,
            'id' => $id,
            'mdp' => $mdp,
            'nom' => $nom,
            'prenom' => $prenom,
            'ville' => $ville,
            'idUtilisateur' => $_SESSION['id']
        ]);

        return $p;
    }

    function recupererParametre(string $idUtilisateur, string $param): string
    {
        $req = "SELECT $param FROM parametre WHERE idUtilisateur = :idUtilisateur";
        $p = $this->pdo->prepare($req);
        $p->execute([
            'idUtilisateur' => $idUtilisateur
        ]);

        $param = $p->fetch()[$param];
        return $param;
    }

    function autorisationParametre(string $idUtilisateur, string $param): bool
    {
        $param = $this->recupererParametre($idUtilisateur, $param);
        $allow = TRUE;
        switch ($param) {
            case 'AMIS':
                if (!$this->estMonAmi($idUtilisateur)) {
                    $allow = FALSE;
                }
            break;

            case 'PRIVEE':
                $allow = FALSE;
            break;
        }

        return $allow;
    }
}