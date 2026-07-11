<?php

require_once __DIR__ . '/../Database.php';
require_once __DIR__ . '/auditeur.php';

class repository {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnexion();
    }

    // CREATE : ajouter un auditeur
    public function ajouter(Auditeur $auditeur): bool {
        $sql = "INSERT INTO auditeur (nom, prenom, email, role, anciennete, specialisation, telephone, date_entree, statut, certifications)
                VALUES (:nom, :prenom, :email, :role, :anciennete, :specialisation, :telephone, :date_entree, :statut, :certifications)";

        $stmt = $this->db->prepare($sql);

        $success = $stmt->execute([
            'nom'            => $auditeur->nom,
            'prenom'         => $auditeur->prenom,
            'email'          => $auditeur->email,
            'role'           => $auditeur->role,
            'anciennete'     => $auditeur->anciennete,
            'specialisation' => $auditeur->specialisation,
            'telephone'      => $auditeur->telephone,
            'date_entree'    => $auditeur->date_entree,
            'statut'         => $auditeur->statut,
            'certifications' => $auditeur->certifications
        ]);

        if ($success) {
            $auditeur->id = (int) $this->db->lastInsertId();
        }

        return $success;
    }

    // READ : récupérer tous les auditeurs
    public function getAll(): array {
        $stmt = $this->db->query("SELECT * FROM auditeur");
        $resultats = $stmt->fetchAll();

        $auditeurs = [];
        foreach ($resultats as $ligne) {
            $auditeurs[] = new Auditeur(
                $ligne['nom'],
                $ligne['prenom'],
                $ligne['email'],
                $ligne['role'],
                $ligne['anciennete'],
                $ligne['specialisation'],
                $ligne['telephone'],
                $ligne['date_entree'],
                $ligne['statut'],
                $ligne['certifications'],
                $ligne['id']
            );
        }
        return $auditeurs;
    }

    // READ : récupérer un auditeur par son id
    public function getById(int $id): ?Auditeur {
        $sql = "SELECT * FROM auditeur WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $ligne = $stmt->fetch();

        if (!$ligne) {
            return null;
        }

        return new Auditeur(
            $ligne['id'],
            $ligne['nom'],
            $ligne['prenom'],
            $ligne['email'],
            $ligne['role'],
            $ligne['anciennete'],
            $ligne['specialisation'],
            $ligne['telephone'],
            $ligne['date_entree'],
            $ligne['statut'],
            $ligne['certifications']
        );
    }

    // UPDATE : mettre à jour un auditeur
    public function modifier(Auditeur $auditeur): bool {
        $sql = "UPDATE auditeur SET
                    nom = :nom,
                    prenom = :prenom,
                    email = :email,
                    role = :role,
                    anciennete = :anciennete,
                    specialisation = :specialisation,
                    telephone = :telephone,
                    date_entree = :date_entree,
                    statut = :statut,
                    certifications = :certifications
                WHERE email = :email";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'nom'            => $auditeur->nom,
            'prenom'         => $auditeur->prenom,
            'email'          => $auditeur->email,
            'role'           => $auditeur->role,
            'anciennete'     => $auditeur->anciennete,
            'specialisation' => $auditeur->specialisation,
            'telephone'      => $auditeur->telephone,
            'date_entree'    => $auditeur->date_entree,
            'statut'         => $auditeur->statut,
            'certifications' => $auditeur->certifications,
        ]);
    }

    // DELETE : supprimer un auditeur
    public function supprimer(int $id): bool {
        $sql = "DELETE FROM auditeur WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}