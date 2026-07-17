<?php

require_once __DIR__ . '/../Database.php';
require_once __DIR__ . '/plan.php';
require_once __DIR__ . '/plan_rapide.php';

class Repository {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnexion();
    }

    // CREATE : ajouter un plan
    public function ajouter(Plan $plan): bool {
        $sql = "INSERT INTO plan (
                    ref,societe_auditee,intitule,date_debut,date_fin,contexte,obj_general,obj_specifiques,services,actual_start,actual_end,lieu,debmois,finmois,debans,finans,fpointfort,fstatut,fdifficulte,cycle,progress,auditor,superviseur,equipe,risque,statut,ftype,cycle_additionnel,missionCategory
                ) VALUES (
                    :ref,
                    :societe,
                    :title,
                    :debut,
                    :fin,
                    :contexte,
                    :obj_general,
                    :obj_specifiques,
                    :services,
                    :actual_start,
                    :actual_end,
                    :lieu,
                    :debmois,
                    :finmois,
                    :debans,
                    :finans,
                    :fpointfort,
                    :fstatut,
                    :fdifficulte,
                    :cycle,
                    :progress,
                    :auditor,
                    :superviseur,
                    :equipe,
                    :risque,
                    :statut,
                    :ftype,
                    :cycle_additionnel,
                    :missionCategory
                )";

        $stmt = $this->db->prepare($sql);

        $success = $stmt->execute($this->toParams($plan));

        if ($success) {
            $plan->id = (int) $this->db->lastInsertId();
        }

        return $success;
    }

    // READ : récupérer tous les plans
    public function getAll(): array {
        $stmt = $this->db->query("SELECT * FROM plan");
        $resultats = $stmt->fetchAll();

        $plans = [];
        foreach ($resultats as $ligne) {
            $plans[] = $this->hydrate($ligne);
        }
        return $plans;
    }

    // READ : récupérer un plan par son id
    public function getById(int $id): ?Plan {
        $sql = "SELECT * FROM plan WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $ligne = $stmt->fetch();

        if (!$ligne) {
            return null;
        }

        return $this->hydrate($ligne);
    }

    // UPDATE : mettre à jour un plan
    public function modifier(Plan $plan): bool {
        $sql = "UPDATE plan SET
            societe_auditee=:societe,
            intitule=:title,
            date_debut=:debut,
            date_fin=:fin,
            contexte=:contexte,
            obj_general=:obj_general,
            obj_specifiques=:obj_specifiques,
            services=:services,
            actual_start=:actual_start,
            actual_end=:actual_end,
            lieu=:lieu,
            debmois=:debmois,
            finmois=:finmois,
            debans=:debans,
            finans=:finans,
            fpointfort=:fpointfort,
            fstatut=:fstatut,
            fdifficulte=:fdifficulte,
            cycle=:cycle,
            progress=:progress,
            auditor=:auditor,
            superviseur=:superviseur,
            equipe=:equipe,
            risque=:risque,
            statut=:statut,
            ftype=:ftype,
            cycle_additionnel=:cycle_additionnel,
            missionCategory=:missionCategory
        WHERE ref = :ref";

        $stmt = $this->db->prepare($sql);

        $params = $this->toParams($plan);
        $params['ref'] = $plan->ref;

        return $stmt->execute($params);
    }

    public function modifier_rapide(Plan_rapide $plan): bool {
        $sql = "UPDATE plan SET
            fstatut=:fstatut,
            progress=:progress
        WHERE ref = :ref";

        $stmt = $this->db->prepare($sql);

        $params = $this->toParams1($plan);
        $params['ref'] = $plan->ref;

        return $stmt->execute($params);
    }

    // DELETE : supprimer un plan
    public function supprimer(int $id): bool {
        $sql = "DELETE FROM plan WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    // Construit un objet Plan à partir d'une ligne de résultat SQL
    private function hydrate(array $ligne): Plan {
        return new Plan(
            $ligne['ref'],
            $ligne['societe_auditee'],      // ← corrigé (au lieu de 'societe')
            $ligne['intitule'],             // ← corrigé (au lieu de 'title')
            $ligne['date_debut'],           // ← corrigé (au lieu de 'debut')
            $ligne['date_fin'],             // ← corrigé (au lieu de 'fin')
            $ligne['contexte'],
            $ligne['obj_general'],
            $ligne['obj_specifiques'],
            $ligne['services'],
            $ligne['actual_start'],
            $ligne['actual_end'],
            $ligne['lieu'],
            $ligne['debmois'],
            $ligne['finmois'],
            $ligne['debans'],
            $ligne['finans'],
            $ligne['fpointfort'],
            $ligne['fstatut'],
            $ligne['fdifficulte'],
            $ligne['cycle'],
            $ligne['progress'],
            $ligne['auditor'],
            $ligne['superviseur'],
            json_decode($ligne['equipe'], true) ?? [],
            $ligne['risque'],
            $ligne['statut'],
            $ligne['ftype'],
            json_decode($ligne['cycle_additionnel'], true) ?? [],
            $ligne['missionCategory'],
        );
    }

    // Construit le tableau de paramètres pour les requêtes préparées
    private function toParams(Plan $plan): array {
        return [
            'ref'                 => $plan->ref,
            'societe'                 => $plan->societe,
            'title'                 => $plan->title,
            'debut'                 => $plan->debut,
            'fin'                 => $plan->fin,
            'contexte'                 => $plan->contexte,
            'obj_general'                 => $plan->obj_general,
            'obj_specifiques'                 => $plan->obj_specifiques,
            'services'                 => $plan->services,
            'actual_start'                 => $plan->actual_start,
            'actual_end'                 => $plan->actual_end,
            'lieu'                 => $plan->lieu,
            'debmois'                 => $plan->debmois,
            'finmois'                 => $plan->finmois,
            'debans'                 => $plan->debans,
            'finans'                 => $plan->finans,
            'fpointfort'                 => $plan->fpointfort,
            'fstatut'                 => $plan->fstatut,
            'fdifficulte'                 => $plan->fdifficulte,
            'cycle'                 => $plan->cycle,
            'progress'                 => $plan->progress,
            'auditor'                 => $plan->auditor,
            'superviseur'                 => $plan->superviseur,
            'equipe'                 => json_encode($plan->equipe),
            'risque'                 => $plan->risque,
            'statut'                 => $plan->statut,
            'cycle_additionnel'                 => json_encode($plan->cycle_additionnel),
            'ftype'                 => $plan->ftype,
            'missionCategory'       => $plan->missionCategory,
            ];
    }

    private function toParams1(Plan_rapide $plan): array {
        return [
            'fstatut'                 => $plan->fstatut,
            'progress'                 => $plan->progress
            ];
    }
}