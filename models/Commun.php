<?php

class Commun {
    protected $pdo;

    public function __construct()
    {
        $this->pdo = new PDO('mysql:host=localhost;dbname=mynetwork', 'root', '', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }

    function estConnecte(): bool
    {
        return !empty($_SESSION['id']);
    }

    function getLesPostes(): array
    {
        $req = "SELECT p.id, p.auteur, p.message, p.datePublication,
                u.avatar, u.nom, u.prenom
                FROM poste p JOIN utilisateur u on p.auteur = u.identifiant
                ORDER BY datePublication DESC";
        $p = $this->pdo->query($req);

        $publications = $p->fetchAll();
        return $publications;
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
        $req = "SELECT id, avatar, nom, prenom, mdp, sexe, dateNaissance, ville, dateCreation
                FROM utilisateur WHERE id = :idUtilisateur";
        $p = $this->pdo->prepare($req);
        $p->execute([
            'idUtilisateur' => $idUtilisateur
        ]);

        $utilisateur = $p->fetchAll();
        return $utilisateur;
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


    function getLesAmis(string $idUtilisateur, bool $relyUsersSetting = FALSE): array
    {
        if ($relyUsersSetting === TRUE) {
            $req = "SELECT idAmi, avatar, nom, prenom FROM amis
                    JOIN utilisateur on amis.idAmi = utilisateur.id
                    JOIN parametre on parametre.idUtilisateur = utilisateur.id
                    WHERE amis.idUtilisateur = :idUtilisateur AND parametre.amis = 'TOUS'";
        } else {
            // Recupère tous les amis de l'utilisateur peu importe leur paramètre
            $req = "SELECT idAmi, avatar, nom, prenom FROM amis
                    JOIN utilisateur on amis.idAmi = utilisateur.id
                    WHERE amis.idUtilisateur = :idUtilisateur";
        }

        $p = $this->pdo->prepare($req);
        $p->execute([
            'idUtilisateur' => $idUtilisateur
        ]);

        $amis = $p->fetchAll();
        return $amis;
    }


    

    
}