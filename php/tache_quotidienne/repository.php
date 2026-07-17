<?php

require_once __DIR__ . '/../Database.php';
require_once __DIR__ . '/tache_quotidienne.php';
require_once __DIR__ . '/tache_rapide.php';

class Repository {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnexion();
    }

    // CREATE : ajouter une tâche
    public function ajouter(TacheQuotidienne $tache_quotidienne): bool {
        $sql = "INSERT INTO tache_quotidiennes (
                    titre, priorite, statut, date, responsable, societe,
                    avancement, duree_heures, notes, permanent,
                    recurrenceType, recurrenceDow, recurrenceDom, fiches_completion
                ) VALUES (
                    :titre, :priorite, :statut, :date, :responsable, :societe,
                    :avancement, :duree_heures, :notes, :permanent,
                    :recurrenceType, :recurrenceDow, :recurrenceDom, :fiches_completion
                )";

        $stmt = $this->db->prepare($sql);
        $success = $stmt->execute($this->toParams($tache_quotidienne));

        if ($success) {
            $tache_quotidienne->id = (int) $this->db->lastInsertId();
        }

        return $success;
    }

    // READ : récupérer toutes les tâches
    public function getAll(): array {
        $stmt = $this->db->query("SELECT * FROM tache_quotidiennes");
        $resultats = $stmt->fetchAll();

        $tache_quotidiennes = [];
        foreach ($resultats as $ligne) {
            $tache_quotidiennes[] = $this->hydrate($ligne);
        }
        return $tache_quotidiennes;
    }

    // READ : récupérer une tâche par son id
    public function getById(int $id): ?TacheQuotidienne {
        $sql = "SELECT * FROM tache_quotidiennes WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $ligne = $stmt->fetch();

        if (!$ligne) {
            return null;
        }

        return $this->hydrate($ligne);
    }

    // UPDATE : mettre à jour une tâche
    public function modifier(TacheQuotidienne $tache_quotidienne): bool {
        $sql = "UPDATE tache_quotidiennes SET
            titre=:titre,
            priorite=:priorite,
            statut=:statut,
            date=:date,
            responsable=:responsable,
            societe=:societe,
            avancement=:avancement,
            duree_heures=:duree_heures,
            notes=:notes,
            permanent=:permanent,
            recurrenceType=:recurrenceType,
            recurrenceDow=:recurrenceDow,
            recurrenceDom=:recurrenceDom,
            fiches_completion=:fiches_completion
        WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        $params = $this->toParams($tache_quotidienne);
        $params['id'] = $tache_quotidienne->id;

        return $stmt->execute($params);
    }

    public function modifier_rapide(Tache_rapide $tache): bool {
        $sql = "UPDATE tache_quotidiennes SET
            avancement=:avancement
        WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        $params = $this->toParams1($tache);

        return $stmt->execute($params);
    }

    // DELETE : supprimer une tâche
    public function supprimer(int $id): bool {
        $sql = "DELETE FROM tache_quotidiennes WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    private function decodeArrayField($value) {
        if (is_array($value)) return $value;
        $decoded = json_decode($value, true);
        return is_array($decoded) ? $decoded : [];
    }

    // Construit un objet TacheQuotidienne à partir d'une ligne de résultat SQL
    private function hydrate(array $ligne): TacheQuotidienne {
        return new TacheQuotidienne(
            $ligne['titre'],
            $ligne['priorite'],
            $ligne['statut'],
            $ligne['date'],
            $ligne['responsable'],
            $ligne['societe'],
            $ligne['avancement'],
            $ligne['duree_heures'],
            $ligne['notes'],
            (bool) $ligne['permanent'],
            $ligne['recurrenceType'],
            $this->decodeArrayField($ligne['recurrenceDow']) ?? [],
            $this->decodeArrayField($ligne['recurrenceDom']) ?? [],
            $this->decodeArrayField($ligne['fiches_completion']) ?? [],
            $ligne['id']
        );
    }

    // Construit le tableau de paramètres pour les requêtes préparées
    private function toParams(TacheQuotidienne $tache_quotidienne): array {
        return [
            'titre'             => $tache_quotidienne->titre,
            'priorite'          => $tache_quotidienne->priorite,
            'statut'            => $tache_quotidienne->statut,
            'date'              => $tache_quotidienne->date,
            'responsable'       => $tache_quotidienne->responsable,
            'societe'           => $tache_quotidienne->societe,
            'avancement'        => $tache_quotidienne->avancement,
            'duree_heures'      => $tache_quotidienne->duree_heures,
            'notes'             => $tache_quotidienne->notes,
            'permanent'         => $tache_quotidienne->permanent ? 1 : 0,
            'recurrenceType'    => json_encode($tache_quotidienne->recurrenceType, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
            'recurrenceDow'     => json_encode($tache_quotidienne->recurrenceDow, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
            'recurrenceDom'     => json_encode($tache_quotidienne->recurrenceDom, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
            'fiches_completion' => json_encode($tache_quotidienne->fiches_completion, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
        ];
    }

    private function toParams1(Tache_rapide $tache): array {
        return [
            'avancement'                 => $tache->avancement,
            'id'                 => $tache->id
            ];
    }
}