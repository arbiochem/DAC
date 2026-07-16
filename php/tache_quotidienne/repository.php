<?php

require_once __DIR__ . '/../Database.php';
require_once __DIR__ . '/frap.php';

class Repository {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnexion();
    }

    // CREATE : ajouter une ligne FRAP
    public function ajouter(Frap $frap): bool {
        $sql = "INSERT INTO frap (
                    numero, ref, audit_refs, taf_ref, titre, criticite, societe, cycle,
                    auditeur, description, causes, consequences, recommandations, actions,
                    preuves, created_at, updated_at
                ) VALUES (
                    :numero, :ref, :audit_refs, :taf_ref, :titre, :criticite, :societe, :cycle,
                    :auditeur, :description, :causes, :consequences, :recommandations, :actions,
                    :preuves, :created_at, :updated_at
                )";

        $stmt = $this->db->prepare($sql);
        $success = $stmt->execute($this->toParams($frap));

        if ($success) {
            $frap->id = (int) $this->db->lastInsertId();
        }

        return $success;
    }

    // READ : récupérer toutes les lignes FRAP
    public function getAll(): array {
        $stmt = $this->db->query("SELECT * FROM frap");
        $resultats = $stmt->fetchAll();

        $fraps = [];
        foreach ($resultats as $ligne) {
            $fraps[] = $this->hydrate($ligne);
        }
        return $fraps;
    }

    // READ : récupérer une ligne FRAP par son id
    public function getById(int $id): ?Frap {
        $sql = "SELECT * FROM frap WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $ligne = $stmt->fetch();

        if (!$ligne) {
            return null;
        }

        return $this->hydrate($ligne);
    }

    // UPDATE : mettre à jour une ligne FRAP
    public function modifier(Frap $frap): bool {
        $sql = "UPDATE frap SET
            numero=:numero,
            ref=:ref,
            audit_refs=:audit_refs,
            taf_ref=:taf_ref,
            titre=:titre,
            criticite=:criticite,
            societe=:societe,
            cycle=:cycle,
            auditeur=:auditeur,
            description=:description,
            causes=:causes,
            consequences=:consequences,
            recommandations=:recommandations,
            actions=:actions,
            preuves=:preuves,
            created_at=:created_at,
            updated_at=:updated_at
        WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        $params = $this->toParams($frap);
        $params['id'] = $frap->id;

        return $stmt->execute($params);
    }

    // DELETE : supprimer une ligne FRAP
    public function supprimer(int $id): bool {
        $sql = "DELETE FROM frap WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    private function decodeArrayField($value) {
        if (is_array($value)) return $value;
        $decoded = json_decode($value, true);
        return is_array($decoded) ? $decoded : [];
    }

    // Construit un objet Frap à partir d'une ligne de résultat SQL
    private function hydrate(array $ligne): Frap {
        return new Frap(
            $ligne['numero'],
            $ligne['ref'],
            $this->decodeArrayField($ligne['audit_refs']) ?? [],
            $this->decodeArrayField($ligne['taf_ref']) ?? [],
            $ligne['titre'],
            $ligne['criticite'],
            $ligne['societe'],
            $ligne['cycle'],
            $ligne['auditeur'],
            $ligne['description'],
            $ligne['causes'],
            $ligne['consequences'],
            $this->decodeArrayField($ligne['recommandations']) ?? [],
            $this->decodeArrayField($ligne['actions']) ?? [],
            $this->decodeArrayField($ligne['preuves']) ?? [],
            $ligne['created_at'],
            $ligne['updated_at'],
            $ligne['id']
        );
    }

    // Construit le tableau de paramètres pour les requêtes préparées
    private function toParams(Frap $frap): array {
        return [
            'numero'          => $frap->numero,
            'ref'             => $frap->ref,
            'audit_refs'      => json_encode($frap->audit_refs, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
            'taf_ref'         => json_encode($frap->taf_ref, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
            'titre'           => $frap->titre,
            'criticite'       => $frap->criticite,
            'societe'         => $frap->societe,
            'cycle'           => $frap->cycle,
            'auditeur'        => $frap->auditeur,
            'description'     => $frap->description,
            'causes'          => $frap->causes,
            'consequences'    => $frap->consequences,
            'recommandations' => json_encode($frap->recommandations, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
            'actions'         => json_encode($frap->actions, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
            'preuves'         => json_encode($frap->preuves, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
            'created_at'      => $frap->created_at,
            'updated_at'      => $frap->updated_at
        ];
    }
}