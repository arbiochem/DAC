<?php

require_once __DIR__ . '/../Database.php';
require_once __DIR__ . '/risque.php';

class Repository {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnexion();
    }

    // CREATE : ajouter une ligne RISQUE
    public function ajouter(Risque $risque): bool {
        $sql = "INSERT INTO risque (
                    titre, societe, categorie, statut, probabilite, impact, score, score_residuel,
                    ctrl_type, ctrl_description, mitigate_strategy, mitigate_plan, mitigate_deadline,
                    mitigate_owner, responsable, echeance, description,coso_pilotage,coso_info_comm,coso_activites_ctrl
                    ,coso_eval_risques,coso_env_controle
                ) VALUES (
                    :titre, :societe, :categorie, :statut, :probabilite, :impact, :score, :score_residuel,
                    :ctrl_type, :ctrl_description, :mitigate_strategy, :mitigate_plan, :mitigate_deadline,
                    :mitigate_owner, :responsable, :echeance, :description,:coso_pilotage,:coso_info_comm,:coso_activites_ctrl
                    ,:coso_eval_risques,:coso_env_controle
                )";

        $stmt = $this->db->prepare($sql);
        $success = $stmt->execute($this->toParams($risque));

        if ($success) {
            $risque->id = (int) $this->db->lastInsertId();
        }

        return $success;
    }

    // READ : récupérer toutes les lignes RISQUE
    public function getAll(): array {
        $stmt = $this->db->query("SELECT * FROM risque");
        $resultats = $stmt->fetchAll();

        $risques = [];
        foreach ($resultats as $ligne) {
            $risques[] = $this->hydrate($ligne);
        }
        return $risques;
    }

    // READ : récupérer une ligne RISQUE par son id
    public function getById(int $id): ?Risque {
        $sql = "SELECT * FROM risque WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $ligne = $stmt->fetch();

        if (!$ligne) {
            return null;
        }

        return $this->hydrate($ligne);
    }

    // UPDATE : mettre à jour une ligne RISQUE
    public function modifier(Risque $risque): bool {
        $sql = "UPDATE risque SET
            titre=:titre,
            societe=:societe,
            categorie=:categorie,
            statut=:statut,
            probabilite=:probabilite,
            impact=:impact,
            score=:score,
            score_residuel=:score_residuel,
            ctrl_type=:ctrl_type,
            ctrl_description=:ctrl_description,
            mitigate_strategy=:mitigate_strategy,
            mitigate_plan=:mitigate_plan,
            mitigate_deadline=:mitigate_deadline,
            mitigate_owner=:mitigate_owner,
            responsable=:responsable,
            echeance=:echeance,
            description=:description,
            coso_pilotage=:coso_pilotage,
            coso_info_comm=:coso_info_comm,
            coso_activites_ctrl=:coso_activites_ctrl,
            coso_eval_risques=:coso_eval_risques,
            coso_env_controle=:coso_env_controle
        WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        $params = $this->toParams($risque);
        $params['id'] = $risque->id;

        return $stmt->execute($params);
    }

    // DELETE : supprimer une ligne RISQUE
    public function supprimer(int $id): bool {
        $sql = "DELETE FROM risque WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    // Construit un objet Risque à partir d'une ligne de résultat SQL
    private function hydrate(array $ligne): Risque {
        return new Risque(
            $ligne['titre'],
            $ligne['societe'],
            $ligne['categorie'],
            $ligne['statut'],
            $ligne['probabilite'],
            $ligne['impact'],
            $ligne['score'],
            $ligne['score_residuel'],
            $ligne['ctrl_type'],
            $ligne['ctrl_description'],
            $ligne['mitigate_strategy'],
            $ligne['mitigate_plan'],
            $ligne['mitigate_deadline'],
            $ligne['mitigate_owner'],
            $ligne['responsable'],
            $ligne['echeance'],
            $ligne['description'],
            $ligne['coso_pilotage'],
            $ligne['coso_info_comm'],
            $ligne['coso_activites_ctrl'],
            $ligne['coso_eval_risques'],
            $ligne['coso_env_controle'],
            $ligne['id']
        );
    }

    // Construit le tableau de paramètres pour les requêtes préparées
    private function toParams(Risque $risque): array {
        return [
            'titre'             => $risque->titre,
            'societe'           => $risque->societe,
            'categorie'         => $risque->categorie,
            'statut'            => $risque->statut,
            'probabilite'       => $risque->probabilite,
            'impact'            => $risque->impact,
            'score'             => $risque->score,
            'score_residuel'    => $risque->score_residuel,
            'ctrl_type'         => $risque->ctrl_type,
            'ctrl_description'  => $risque->ctrl_description,
            'mitigate_strategy' => $risque->mitigate_strategy,
            'mitigate_plan'     => $risque->mitigate_plan,
            'mitigate_deadline' => $risque->mitigate_deadline,
            'mitigate_owner'    => $risque->mitigate_owner,
            'responsable'       => $risque->responsable,
            'echeance'          => $risque->echeance,
            'description'       => $risque->description,
            'coso_pilotage'       => $risque->coso_pilotage,
            'coso_info_comm'       => $risque->coso_info_comm,
            'coso_activites_ctrl'       => $risque->coso_activites_ctrl,
            'coso_eval_risques'       => $risque->coso_eval_risques,
            'coso_env_controle'       => $risque->coso_env_controle,
        ];
    }
}