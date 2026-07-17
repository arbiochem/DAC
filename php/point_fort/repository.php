<?php

require_once __DIR__ . '/../Database.php';
require_once __DIR__ . '/point_fort.php';

class Repository {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnexion();
    }

    // CREATE : ajouter un point fort
    public function ajouter(Point_fort $pointFort): bool {
        $sql = "INSERT INTO point_fort (auditRef, processus, pointFort, impact)
                VALUES (:auditRef, :processus, :pointFort, :impact)";

        $stmt = $this->db->prepare($sql);
        $success = $stmt->execute($this->toParams($pointFort));

        if ($success) {
            $pointFort->id = (int) $this->db->lastInsertId();
        }

        return $success;
    }

    // READ : récupérer tous les points forts
    public function getAll(): array {
        $stmt = $this->db->query("SELECT * FROM point_fort");
        $resultats = $stmt->fetchAll();

        $pointsForts = [];
        foreach ($resultats as $ligne) {
            $pointsForts[] = $this->hydrate($ligne);
        }
        return $pointsForts;
    }

    // READ : récupérer un point fort par son id
    public function getById(int $id): ?Point_fort {
        $sql = "SELECT * FROM point_fort WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $ligne = $stmt->fetch();

        if (!$ligne) {
            return null;
        }

        return $this->hydrate($ligne);
    }

    // UPDATE : mettre à jour un point fort
    public function modifier(Point_fort $pointFort): bool {
        $sql = "UPDATE point_fort SET
                    auditRef = :auditRef,
                    processus = :processus,
                    pointFort = :pointFort,
                    impact = :impact
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        $params = $this->toParams($pointFort);
        $params['id'] = $pointFort->id;

        return $stmt->execute($params);
    }

    // DELETE : supprimer un point fort
    public function supprimer(int $id): bool {
        $sql = "DELETE FROM point_fort WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    // Construit un objet Point_fort à partir d'une ligne de résultat SQL
    private function hydrate(array $ligne): Point_fort {
        return new Point_fort(
            $ligne['auditRef'],
            $ligne['processus'],
            $ligne['pointFort'],
            $ligne['impact'],
            $ligne['id']
        );
    }

    // Construit le tableau de paramètres pour les requêtes préparées
    private function toParams(Point_fort $pointFort): array {
        return [
            'auditRef'  => $pointFort->auditRef,
            'processus' => $pointFort->processus,
            'pointFort' => $pointFort->pointFort,
            'impact'    => $pointFort->impact,
        ];
    }
}