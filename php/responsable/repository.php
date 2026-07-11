<?php

require_once __DIR__ . '/../Database.php';
require_once __DIR__ . '/responsable.php';

class Repository {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnexion();
    }

    // CREATE : ajouter un responsable
    public function ajouter(Responsable $responsable): bool {
        $sql = "INSERT INTO responsable (nom, prenom, email, fonction, direction, telephone, statut, nom_societe)
                VALUES (:nom, :prenom, :email, :fonction, :direction, :telephone, :statut, :nom_societe)";

        $stmt = $this->db->prepare($sql);

        $success = $stmt->execute([
            'nom'         => $responsable->nom,
            'prenom'      => $responsable->prenom,
            'email'       => $responsable->email,
            'fonction'    => $responsable->fonction,
            'direction'   => $responsable->direction,
            'telephone'   => $responsable->telephone,
            'statut'      => $responsable->statut,
            'nom_societe' => $responsable->nom_societe,
        ]);

        if ($success) {
            $responsable->id = (int) $this->db->lastInsertId();
        }

        return $success;
    }

    // READ : récupérer tous les responsables
    public function getAll(): array {
        $stmt = $this->db->query("SELECT * FROM responsable");
        $resultats = $stmt->fetchAll();

        $responsables = [];
        foreach ($resultats as $ligne) {
            $responsables[] = new Responsable(
                $ligne['nom'],
                $ligne['prenom'],
                $ligne['email'],
                $ligne['fonction'],
                $ligne['direction'],
                $ligne['telephone'],
                $ligne['statut'],
                $ligne['nom_societe'],
                $ligne['id']
            );
        }
        return $responsables;
    }

    // READ : récupérer un responsable par son id
    public function getById(int $id): ?Responsable {
        $sql = "SELECT * FROM responsable WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $ligne = $stmt->fetch();

        if (!$ligne) {
            return null;
        }

        return new Responsable(
            $ligne['nom'],
            $ligne['prenom'],
            $ligne['email'],
            $ligne['fonction'],
            $ligne['direction'],
            $ligne['telephone'],
            $ligne['statut'],
            $ligne['nom_societe'],
            $ligne['id']
        );
    }

    // UPDATE : mettre à jour un responsable
    public function modifier(Responsable $responsable): bool {
        $sql = "UPDATE responsable SET
                    nom = :nom,
                    prenom = :prenom,
                    email = :email,
                    fonction = :fonction,
                    direction = :direction,
                    telephone = :telephone,
                    statut = :statut,
                    nom_societe = :nom_societe
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'nom'         => $responsable->nom,
            'prenom'      => $responsable->prenom,
            'email'       => $responsable->email,
            'fonction'    => $responsable->fonction,
            'direction'   => $responsable->direction,
            'telephone'   => $responsable->telephone,
            'statut'      => $responsable->statut,
            'nom_societe' => $responsable->nom_societe,
            'id'          => $responsable->id,
        ]);
    }

    // DELETE : supprimer un responsable
    public function supprimer(int $id): bool {
        $sql = "DELETE FROM responsable WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}