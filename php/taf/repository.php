<?php

require_once __DIR__ . '/../Database.php';
require_once __DIR__ . '/taf.php';

class Repository {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnexion();
    }

    // CREATE : ajouter une TAF
    public function ajouter(Taf $taf): bool {
        $sql = "INSERT INTO taf (
                    categorie, titre, programme, docs, contact,
                    testplan, testresults, priorite, statut, auditeur, notes, societes_multi, audit_refs, fiches_test
                ) VALUES (
                    :categorie, :titre, :programme, :docs, :contact,
                    :testplan, :testresults, :priorite, :statut, :auditeur, :notes,
                    :societes_multi,
                    :audit_refs,
                    :fiches_test
                )";

        $stmt = $this->db->prepare($sql);
        $success = $stmt->execute($this->toParams($taf));

        if ($success) {
            $taf->id = (int) $this->db->lastInsertId();
        }

        return $success;
    }

    // READ : récupérer toutes les TAF
    public function getAll(): array {
        $stmt = $this->db->query("SELECT * FROM taf");
        $resultats = $stmt->fetchAll();

        $tafs = [];
        foreach ($resultats as $ligne) {
            $tafs[] = $this->hydrate($ligne);
        }
        return $tafs;
    }

    // READ : récupérer une TAF par son id
    public function getById(int $id): ?Taf {
        $sql = "SELECT * FROM taf WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $ligne = $stmt->fetch();

        if (!$ligne) {
            return null;
        }

        return $this->hydrate($ligne);
    }

    // UPDATE : mettre à jour une TAF
    public function modifier(Taf $taf): bool {
        $sql = "UPDATE taf SET
            categorie=:categorie,
            titre=:titre,
            programme=:programme,
            docs=:docs,
            contact=:contact,
            testplan=:testplan,
            testresults=:testresults,
            priorite=:priorite,
            statut=:statut,
            auditeur=:auditeur,
            notes=:notes,
            societes_multi=:societes_multi,
            audit_refs=:audit_refs,
            fiches_test=:fiches_test,
            statut_updated_at=:statut_updated_at,
            updated_at=:updated_at
        WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        $params = $this->toParams($taf);
        $params['id'] = $taf->id;

        return $stmt->execute($params);
    }

    // DELETE : supprimer une TAF
    public function supprimer(int $id): bool {
        $sql = "DELETE FROM taf WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    private function decodeArrayField($value) {
        if (is_array($value)) return $value;
        $decoded = json_decode($value, true);
        return is_array($decoded) ? $decoded : [];
    }

    // Construit un objet Taf à partir d'une ligne de résultat SQL
    private function hydrate(array $ligne): Taf {
        return new Taf(
            $ligne['categorie'],
            $ligne['titre'],
            $ligne['programme'],
            $this->decodeArrayField($ligne['docs'], true) ?? [],
            $ligne['contact'],
            $ligne['testplan'],
            $ligne['testresults'],
            $ligne['priorite'],
            $ligne['statut'],
            $ligne['auditeur'],
            $ligne['notes'],
            $ligne['statut_updated_at'],
            $ligne['updated_at'],
            $this->decodeArrayField($ligne['societes_multi'], true) ?? [],
            $this->decodeArrayField($ligne['audit_refs'], true) ?? [],
            $this->decodeArrayField($ligne['fiches_test'], true) ?? [],
            $ligne['id']
        );
    }

    // Construit le tableau de paramètres pour les requêtes préparées
    private function toParams(Taf $taf): array {
        return [
            'categorie'   => $taf->categorie,
            'titre'       => $taf->titre,
            'programme'      => $taf->programme,
            'docs'           => json_encode($taf->docs),
            'contact'        => $taf->contact,
            'testplan'       => $taf->testplan,
            'testresults'    => $taf->testresults,
            'priorite'       => $taf->priorite,
            'statut'         => $taf->statut,
            'auditeur'       => $taf->auditeur,
            'notes'          => $taf->notes,
            'statut_updated_at'    => $taf->statut_updated_at,
            'updated_at'    => $taf->updated_at,
            'societes_multi' => json_encode($taf->societes_multi),
            'audit_refs'     => json_encode($taf->audit_refs),
            'fiches_test'    => json_encode($taf->fiches_test)
        ];
    }
}