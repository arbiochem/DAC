<?php

require_once __DIR__ . '/../Database.php';
require_once __DIR__ . '/conge.php';

class Repository {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnexion();
    }

    // CREATE : ajouter un congé
    public function ajouter(Conge $conge): bool {
        $sql = "INSERT INTO conge (auditeur, debut, fin, hdebut, hfin, type, statut, note)
                VALUES (:auditeur, :debut, :fin, :hdebut, :hfin, :type, :statut, :note)";

        $stmt = $this->db->prepare($sql);
        $success = $stmt->execute($this->toParams($conge));

        if ($success) {
            $conge->id = (int) $this->db->lastInsertId();
        }

        return $success;
    }

    // READ : récupérer tous les congés
    public function getAll(): array {
        $stmt = $this->db->query("SELECT * FROM conge");
        $resultats = $stmt->fetchAll();

        $conges = [];
        foreach ($resultats as $ligne) {
            $conges[] = $this->hydrate($ligne);
        }
        return $conges;
    }

    // READ : récupérer un congé par son id
    public function getById(int $id): ?Conge {
        $sql = "SELECT * FROM conge WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $ligne = $stmt->fetch();

        if (!$ligne) {
            return null;
        }

        return $this->hydrate($ligne);
    }

    // UPDATE : mettre à jour un congé
    public function modifier(Conge $conge): bool {
        $sql = "UPDATE conge SET
                    auditeur = :auditeur,
                    debut = :debut,
                    fin = :fin,
                    hdebut = :hdebut,
                    hfin = :hfin,
                    type = :type,
                    statut = :statut,
                    note = :note
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        $params = $this->toParams($conge);
        $params['id'] = $conge->id;

        return $stmt->execute($params);
    }

    // DELETE : supprimer un congé
    public function supprimer(int $id): bool {
        $sql = "DELETE FROM conge WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    // Construit un objet Conge à partir d'une ligne de résultat SQL
    private function hydrate(array $ligne): Conge {
        return new Conge(
            $ligne['auditeur'],
            $ligne['debut'],
            $ligne['fin'],
            $ligne['hdebut'],
            $ligne['hfin'],
            $ligne['type'],
            $ligne['statut'],
            $ligne['note'],
            $ligne['id']
        );
    }

    // Construit le tableau de paramètres pour les requêtes préparées
    private function toParams(Conge $conge): array {
        return [
            'auditeur' => $conge->auditeur,
            'debut'    => $conge->debut,
            'fin'      => $conge->fin,
            'hdebut'   => $conge->hdebut,
            'hfin'     => $conge->hfin,
            'type'     => $conge->type,
            'statut'   => $conge->statut,
            'note'     => $conge->note,
        ];
    }
}