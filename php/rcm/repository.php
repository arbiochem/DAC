<?php

require_once __DIR__ . '/../Database.php';
require_once __DIR__ . '/rcm.php';

class Repository {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnexion();
    }

    // CREATE : ajouter une ligne RCM
    public function ajouter(Rcm $rcm): bool {
        $sql = "INSERT INTO rcm (
                    filiale, ref, cycle, processus, tache, objectif, risque,
                    imp_op, imp_fin, imp_rep, impact, likelihood, inherent,
                    controle, efficacite, residuel
                ) VALUES (
                    :filiale, :ref, :cycle, :processus, :tache, :objectif, :risque,
                    :imp_op, :imp_fin, :imp_rep, :impact, :likelihood, :inherent,
                    :controle, :efficacite, :residuel
                )";

        $stmt = $this->db->prepare($sql);
        $success = $stmt->execute($this->toParams($rcm));

        if ($success) {
            $rcm->id = (int) $this->db->lastInsertId();
        }

        return $success;
    }

    // READ : récupérer toutes les lignes RCM
    public function getAll(): array {
        $stmt = $this->db->query("SELECT * FROM rcm");
        $resultats = $stmt->fetchAll();

        $rcms = [];
        foreach ($resultats as $ligne) {
            $rcms[] = $this->hydrate($ligne);
        }
        return $rcms;
    }

    // READ : récupérer une ligne RCM par son id
    public function getById(int $id): ?Rcm {
        $sql = "SELECT * FROM rcm WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $ligne = $stmt->fetch();

        if (!$ligne) {
            return null;
        }

        return $this->hydrate($ligne);
    }

    // UPDATE : mettre à jour une ligne RCM
    public function modifier(Rcm $rcm): bool {
        $sql = "UPDATE rcm SET
            filiale=:filiale,
            cycle=:cycle,
            processus=:processus,
            tache=:tache,
            objectif=:objectif,
            risque=:risque,
            imp_op=:imp_op,
            imp_fin=:imp_fin,
            imp_rep=:imp_rep,
            impact=:impact,
            likelihood=:likelihood,
            inherent=:inherent,
            controle=:controle,
            efficacite=:efficacite,
            residuel=:residuel
        WHERE ref = :ref";

        $stmt = $this->db->prepare($sql);

        $params = $this->toParams($rcm);
        $params['ref'] = $rcm->ref;

        return $stmt->execute($params);
    }

    // DELETE : supprimer une ligne RCM
    public function supprimer(int $id): bool {
        $sql = "DELETE FROM rcm WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    // Construit un objet Rcm à partir d'une ligne de résultat SQL
    private function hydrate(array $ligne): Rcm {
        return new Rcm(
            $ligne['filiale'],
            $ligne['ref'],
            $ligne['cycle'],
            $ligne['processus'],
            $ligne['tache'],
            $ligne['objectif'],
            $ligne['risque'],
            $ligne['imp_op'],
            $ligne['imp_fin'],
            $ligne['imp_rep'],
            $ligne['impact'],
            $ligne['likelihood'],
            $ligne['inherent'],
            $ligne['controle'],
            $ligne['efficacite'],
            $ligne['residuel'],
            $ligne['id']
        );
    }

    // Construit le tableau de paramètres pour les requêtes préparées
    private function toParams(Rcm $rcm): array {
        return [
            'filiale'    => $rcm->filiale,
            'ref'        => $rcm->ref,
            'cycle'      => $rcm->cycle,
            'processus'  => $rcm->processus,
            'tache'      => $rcm->tache,
            'objectif'   => $rcm->objectif,
            'risque'     => $rcm->risque,
            'imp_op'     => $rcm->imp_op,
            'imp_fin'    => $rcm->imp_fin,
            'imp_rep'    => $rcm->imp_rep,
            'impact'     => $rcm->impact,
            'likelihood' => $rcm->likelihood,
            'inherent'   => $rcm->inherent,
            'controle'   => $rcm->controle,
            'efficacite' => $rcm->efficacite,
            'residuel'   => $rcm->residuel,
        ];
    }
}