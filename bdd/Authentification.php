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


    function getLesPublications(): array
    {
        
    }
}