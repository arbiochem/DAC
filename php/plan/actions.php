<?php

require_once 'repository.php';
require_once 'plan.php';
require_once 'plan_rapide.php';

header('Content-Type: application/json');

$action = $_POST['action'] ?? '';

$repo = new Repository();

switch ($action) {
    case 'ajouter':
        $plan = new Plan(
            $_POST['ref'],
            $_POST['societe'],
            $_POST['title'],
            $_POST['debut'],
            $_POST['fin'],
            $_POST['contexte'],
            $_POST['obj_general'],
            $_POST['obj_specifiques'],
            $_POST['services'],
            $_POST['actual_start'],
            $_POST['actual_end'],
            $_POST['lieu'],
            $_POST['debmois'],
            $_POST['finmois'],
            $_POST['debans'],
            $_POST['finans'],
            $_POST['fpointfort'],
            $_POST['fstatut'],
            $_POST['fdifficulte'],
            $_POST['cycle'],
            $_POST['progress'],
            $_POST['auditor'],
            $_POST['superviseur'],
            $_POST['equipe'],
            $_POST['risque'],
            $_POST['statut'],
            $_POST['ftype'],
            $_POST['cycle_additionnel'],
            $_POST['missionCategorie']
        );
        $ok = $repo->ajouter($plan);

        echo json_encode([
            "success" => $ok,
            "id"      => $ok ? $plan->id : null,
        ]);
        break;

    case 'lister':
        $plans = $repo->getAll();

        $data = [];

        foreach ($plans as $p) {

            $data[] = [
                "id"                  => $p->id,
                "ref"                 => $p->ref,
                "actual_end"                 => $p->actual_end,
                "actual_start"                 => $p->actual_start,
                "auditor"                 => $p->auditor,
                "contexte"                 => $p->contexte,
                "cycle"                 => $p->cycle,
                "cycle_additionnel"                 => $p->cycle_additionnel,
                "date_debut"                 => $p->debut,
                "date_fin"                 => $p->fin,
                "debans"                 => $p->debans,
                "debmois"                 => $p->debmois,
                "finans"                 => $p->finans,
                "finmois"                 => $p->finmois,
                "equipe"                 => $p->equipe,
                "fdifficulte"                 => $p->fdifficulte,
                "fpointfort"                 => $p->fpointfort,
                "fstatut"                 => $p->fstatut,
                "ftype"                 => $p->ftype,
                "intitule"                 => $p->title,
                "lieu"                 => $p->lieu,
                "obj_general"                 => $p->obj_general,
                "obj_specifiques"                 => $p->obj_specifiques,
                "progress"                 => $p->progress,
                "risque"                 => $p->risque,
                "services"                 => $p->services,
                "societe_auditee"                 => $p->societe,
                "statut"                 => $p->statut,
                "superviseur"                 => $p->superviseur,
                "missionCategory"                 => $p->missionCategory
            ];

        }

        echo json_encode([
            "success" => true,
            "data" => $data
        ]);
        break;

    case 'modifier':
        $plan = new Plan(
            $_POST['ref'],
            $_POST['societe'],
            $_POST['title'],
            $_POST['debut'],
            $_POST['fin'],
            $_POST['contexte'],
            $_POST['obj_general'],
            $_POST['obj_specifiques'],
            $_POST['services'],
            $_POST['actual_start'],
            $_POST['actual_end'],
            $_POST['lieu'],
            $_POST['debmois'],
            $_POST['finmois'],
            $_POST['debans'],
            $_POST['finans'],
            $_POST['fpointfort'],
            $_POST['fstatut'],
            $_POST['fdifficulte'],
            $_POST['cycle'],
            $_POST['progress'],
            $_POST['auditor'],
            $_POST['superviseur'],
            $_POST['equipe'] ?? [],
            $_POST['risque'],
            $_POST['statut'],
            $_POST['ftype'],
            $_POST['cycle_additionnel'] ?? [],
            $_POST['missionCategorie']
        );

        $ref = $_POST['ref'] ?? null;
        if (!$ref) {
            echo json_encode(["success" => false, "message" => "Référence manquante"]);
            break;
        }

        $ok = $repo->modifier($plan);

        echo json_encode([
            "success" => $ok
        ]);
        break;

    case 'modifier_rapide':
        $plan = new Plan_rapide(
            $_POST['ref'],
            $_POST['fstatut'],
            $_POST['progress']
        );
        
        $ref = $_POST['ref'] ?? null;
        if (!$ref) {
            echo json_encode(["success" => false, "message" => "Référence manquante"]);
            break;
        }

        $ok = $repo->modifier_rapide($plan);

        echo json_encode([
            "success" => $ok
        ]);
        break;
    case 'supprimer':
        $id = $_POST['id'];
        if(!$id){
            echo json_encode(["success" => false, "message" => "ID manquant"]);
            break;
        }
        $ok = $repo->supprimer((int)$id);

        echo json_encode([
            "success" => $ok
        ]);
        break;

    default:
        echo json_encode([
            "success" => false,
            "message" => "Action inconnue"
        ]);
}