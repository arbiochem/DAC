<?php

class Database {
    // L'unique instance de la classe
    private static ?Database $instance = null;

    // La connexion PDO
    private PDO $connexion;

    // Le constructeur est privé : impossible de faire "new Database()"
    private function __construct() {
        $host = '192.168.88.251';
        $dbname = 'dac';
        $user = 'root';
        $password = '';

        try {
             $this->connexion = new PDO(
                "mysql:host=$host;port=3306;dbname=$dbname;charset=utf8mb4",
                $user,
                $password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );
        } catch (PDOException $e) {
            die("Erreur de connexion : " . $e->getMessage());
        }
    }

    // Méthode statique pour récupérer l'instance unique
    public static function getInstance(): Database {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // Récupère l'objet PDO pour exécuter des requêtes
    public function getConnexion(): PDO {
        return $this->connexion;
    }

    // Empêcher le clonage de l'instance
    private function __clone() {}

    // Empêcher la désérialisation (créerait une 2e instance)
    public function __wakeup() {
        throw new Exception("Impossible de désérialiser un singleton.");
    }
}