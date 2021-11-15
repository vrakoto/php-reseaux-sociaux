<?php

class Authentification {
    private string $pdo;

    public function __construct()
    {
        $this->pdo = new PDO('mysql:host=localhost;dbname=mynetwork', 'root', 'root', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }
}