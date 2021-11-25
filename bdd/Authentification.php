<?php

class Authentification {
    private $pdo;

    public function __construct()
    {
        $this->pdo = new PDO('mysql:host=localhost;dbname=mynetwork', 'root', 'root', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }

    function connecte(): bool
    {
        return !empty($_SESSION['id']);
    }

    
    function rechercherPoste(string $typeRecherche, string $valeur): array
    {
        $req = "SELECT p.id, auteur, message, datePublication,
                avatar, nom, prenom
                FROM poste p JOIN utilisateur u on p.auteur = u.id
                WHERE ";

        if ($typeRecherche === 'sujet') {
            $req .= " message";
        } else {
            $req .= " auteur";
        }
        $req .= " LIKE ? ORDER BY datePublication DESC";
        $p = $this->pdo->prepare($req);
        $p->execute(["$valeur%"]);

        $recherche = $p->fetchAll();
        return $recherche;
    }

    function verifierIdentifiant($id): bool
    {
        $req = "SELECT id FROM utilisateur WHERE id = :id";
        $p = $this->pdo->prepare($req);
        $p->execute([
            'id' => $id
        ]);

        $utilisateur = $p->fetch();
        return !empty($utilisateur);
    }

    function inscrire(string $id, string $nom, string $prenom, string $mdp, string $sexe, string $dateNaissance, string $ville): PDOStatement
    {
        $req = "INSERT INTO utilisateur (id, nom, prenom, mdp, sexe, dateNaissance, ville) VALUES (:id, :nom, :prenom, :mdp, :sexe, :dateNaissance, :ville)";
        $p = $this->pdo->prepare($req);
        $p->execute([
            'id' => $id,
            'nom' => $nom,
            'prenom' => $prenom,
            'mdp' => $mdp,
            'sexe' => $sexe,
            'dateNaissance' => $dateNaissance,
            'ville' => $ville
        ]);

        return $p;
    }

    function verifierConnexion(string $id, string $mdp): bool
    {
        $req = "SELECT id, mdp FROM utilisateur WHERE id = :id AND mdp = :mdp";
        $p = $this->pdo->prepare($req);
        $p->execute([
            'id' => $id,
            'mdp' => $mdp
        ]);

        return !empty($p->fetch());
    }

    function getUtilisateur(string $idUtilisateur): array
    {
        $req = "SELECT id, avatar, nom, prenom, sexe, dateNaissance, ville, dateCreation
                FROM utilisateur WHERE id = :idUtilisateur";
        $p = $this->pdo->prepare($req);
        $p->execute([
            'idUtilisateur' => $idUtilisateur
        ]);

        $utilisateur = $p->fetchAll();
        return $utilisateur;
    }


    function getLesPostes(): array
    {
        $req = "SELECT p.id, auteur, message, datePublication,
                avatar, nom, prenom
                FROM poste p JOIN utilisateur u on p.auteur = u.id
                ORDER BY datePublication DESC";
        $p = $this->pdo->query($req);

        $publications = $p->fetchAll();
        return $publications;
    }

    function getLePoste(string $idPoste): array
    {
        $req = "SELECT p.id, auteur, message, datePublication,
                avatar, nom, prenom
                FROM poste p JOIN utilisateur u on p.auteur = u.id
                WHERE p.id = :idPoste
                ORDER BY datePublication DESC";
        $p = $this->pdo->prepare($req);
        $p->execute([
            'idPoste' => $idPoste
        ]);

        $publications = $p->fetchAll();
        return $publications;
    }

    function getLesPostesUtilisateur(string $idUtilisateur, int $limit = NULL): array
    {
        
        $req = "SELECT p.id, auteur, message, datePublication,
                avatar, nom, prenom
                FROM poste p JOIN utilisateur u on p.auteur = u.id
                WHERE auteur = :idUtilisateur
                ORDER BY datePublication DESC";
        if ($limit !== NULL) {
            $req .= " LIMIT $limit";
        }

        $p = $this->pdo->prepare($req);
        $p->execute([
            'idUtilisateur' => $idUtilisateur
        ]);

        $publications = $p->fetchAll();
        return $publications;
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

    function aAimer(string $id): bool
    {
        $req = "SELECT auteur FROM poste_aimer WHERE idPoste = :idPoste AND auteur = :auteur";
        $p = $this->pdo->prepare($req);
        $p->execute([
            'idPoste' => $id,
            'auteur' => $_SESSION['id']
        ]);

        return !empty($p->fetch());
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


    function getLesCommentaires(string $idPoste): array
    {
        $req = "SELECT idPoste, auteur, message, datePublication, avatar, nom, prenom, c.id as idCommentaire
                FROM commentaire c JOIN utilisateur u on c.auteur = u.id
                WHERE idPoste = :idPoste
                ORDER BY datePublication DESC";
        $p = $this->pdo->prepare($req);
        $p->execute([
            'idPoste' => $idPoste
        ]);

        $publications = $p->fetchAll();
        return $publications;
    }

    function getLesCommentairesUtilisateur(string $idUtilisateur, int $limit = NULL): array
    {
        $req = "SELECT idPoste, auteur, message, datePublication, avatar, nom, prenom, c.id as idCommentaire
                FROM commentaire c JOIN utilisateur u on c.auteur = u.id
                WHERE c.auteur = :idUtilisateur
                ORDER BY c.datePublication DESC";
        if ($limit !== NULL) {
            $req .= " LIMIT $limit";
        }
        
        $p = $this->pdo->prepare($req);
        $p->execute([
            'idUtilisateur' => $idUtilisateur
        ]);

        $commentaires = $p->fetchAll();
        return $commentaires;
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


    

    function getLesJaimes(string $idPoste): array
    {
        $req = "SELECT idPoste, auteur, avatar, nom, prenom
                FROM poste_aimer pa JOIN utilisateur u on pa.auteur = u.id
                WHERE idPoste = :idPoste";
        $p = $this->pdo->prepare($req);
        $p->execute([
            'idPoste' => $idPoste
        ]);

        $likes = $p->fetchAll();
        return $likes;
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


    function ajouterListeAmi(): PDOStatement
    {
        $req = "INSERT INTO amis (idUtilisateur) VALUES (:idUtilisateur)";
        $p = $this->pdo->prepare($req);
        $p->execute([
            'idUtilisateur' => $_SESSION['id']
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

    function getLesAmis(string $idUtilisateur): array
    {
        $req = "SELECT idAmi, avatar, nom, prenom FROM amis
                JOIN utilisateur on amis.idAmi = utilisateur.id
                WHERE idUtilisateur = :idUtilisateur";
        $p = $this->pdo->prepare($req);
        $p->execute([
            'idUtilisateur' => $idUtilisateur
        ]);

        $amis = $p->fetchAll();
        return $amis;
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
}