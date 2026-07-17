<?php

require_once __DIR__ . '/../Database.php';
require_once __DIR__ . '/mission.php';

class Repository {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnexion();
    }

    // CREATE : ajouter une mission
    public function ajouter(Mission $mission): bool {
        $sql = "INSERT INTO missions (
                    ref, title, societe, chef, assignees,
                    start, end, progress, status, color, tasks
                ) VALUES (
                    :ref, :title, :societe, :chef, :assignees,
                    :start, :end, :progress, :status, :color, :tasks
                )";

        $stmt = $this->db->prepare($sql);
        $success = $stmt->execute($this->toParams($mission));

        if ($success) {
            $mission->id = (int) $this->db->lastInsertId();
        }

        return $success;
    }

    // READ : récupérer toutes les missions
    public function getAll(): array {
        $stmt = $this->db->query("SELECT * FROM missions");
        $resultats = $stmt->fetchAll();

        $missions = [];
        foreach ($resultats as $ligne) {
            $missions[] = $this->hydrate($ligne);
        }
        return $missions;
    }

    // READ : récupérer une mission par son id
    public function getById(int $id): ?Mission {
        $sql = "SELECT * FROM missions WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $ligne = $stmt->fetch();

        if (!$ligne) {
            return null;
        }

        return $this->hydrate($ligne);
    }

    // UPDATE : mettre à jour une mission
    public function modifier(Mission $mission): bool {
        $sql = "UPDATE missions SET
            ref=:ref,
            title=:title,
            societe=:societe,
            chef=:chef,
            assignees=:assignees,
            start=:start,
            end=:end,
            progress=:progress,
            status=:status,
            color=:color,
            tasks=:tasks
        WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        $params = $this->toParams($mission);
        $params['id'] = $mission->id;

        return $stmt->execute($params);
    }

    // DELETE : supprimer une mission
    public function supprimer(int $id): bool {
        $sql = "DELETE FROM missions WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    private function decodeArrayField($value) {
        if (is_array($value)) return $value;
        $decoded = json_decode($value, true);
        return is_array($decoded) ? $decoded : [];
    }

    // Construit un objet Mission à partir d'une ligne de résultat SQL
    private function hydrate(array $ligne): Mission {
        return new Mission(
            $ligne['ref'],
            $ligne['title'],
            $ligne['societe'],
            $ligne['chef'],
            $this->decodeArrayField($ligne['assignees']) ?? [],
            $ligne['start'],
            $ligne['end'],
            $ligne['progress'],
            $ligne['status'],
            $ligne['color'],
            $this->decodeArrayField($ligne['tasks']) ?? [],
            $ligne['id']
        );
    }

    // Construit le tableau de paramètres pour les requêtes préparées
    private function toParams(Mission $mission): array {
        return [
            'ref'       => $mission->ref,
            'title'     => $mission->title,
            'societe'   => $mission->societe,
            'chef'      => $mission->chef,
            'assignees' => json_encode($mission->assignees, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
            'start'     => $mission->start,
            'end'       => $mission->end,
            'progress'  => $mission->progress,
            'status'    => $mission->status,
            'color'     => $mission->color,
            'tasks'     => json_encode($mission->tasks, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
        ];
    }

    private function toParams1(Mission_rapide $mission): array {
        return [
            'progress' => $mission->progress,
            'status'   => $mission->status,
            'id'       => $mission->id,
        ];
    }
}