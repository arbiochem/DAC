<?php

require_once 'repository.php'; // adapte le chemin/nom si Repository dédié à Risque
require_once 'risque.php';

header('Content-Type: application/json');

$action = $_POST['action'] ?? '';

$repo = new Repository(); // ou RisqueRepository si tu sépares

switch ($action) {
    case 'ajouter':
        $risque = new Risque(
            $_POST['titre'],
            $_POST['societe'],
            $_POST['categorie'],
            $_POST['statut'],
            $_POST['probabilite'],
            $_POST['impact'],
            $_POST['score'],
            $_POST['score_residuel'],
            $_POST['ctrl_type'],
            $_POST['ctrl_description'],
            $_POST['mitigate_strategy'],
            $_POST['mitigate_plan'],
            $_POST['mitigate_deadline'],
            $_POST['mitigate_owner'],
            $_POST['responsable'],
            $_POST['echeance'],
            $_POST['description'],
            $_POST['coso_pilotage'],
            $_POST['coso_info_comm'],
            $_POST['coso_activites_ctrl'],
            $_POST['coso_eval_risques'],
            $_POST['coso_env_controle']
        );

        $ok = $repo->ajouter($risque);

        echo json_encode([
            "success" => $ok,
            "id"      => $ok ? $risque->id : null,
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        break;

    case 'lister':
        $risques = $repo->getAll();

        $data = [];
        foreach ($risques as $r) {
            $data[] = [
                "id"             => $r->id,
                "titre"             => $r->titre,
                "societe"           => $r->societe,
                "categorie"         => $r->categorie,
                "statut"            => $r->statut,
                "probabilite"       => $r->probabilite,
                "impact"            => $r->impact,
                "score"             => $r->score,
                "score_residuel"    => $r->score_residuel,
                "ctrl_type"         => $r->ctrl_type,
                "ctrl_description"  => $r->ctrl_description,
                "mitigate_strategy" => $r->mitigate_strategy,
                "mitigate_plan"     => $r->mitigate_plan,
                "mitigate_deadline" => $r->mitigate_deadline,
                "mitigate_owner"    => $r->mitigate_owner,
                "responsable"       => $r->responsable,
                "echeance"          => $r->echeance,
                "description"       => $r->description,
                "coso_pilotage"       => $r->coso_pilotage,
                "coso_info_comm"       => $r->coso_info_comm,
                "coso_activites_ctrl"       => $r->coso_activites_ctrl,
                "coso_eval_risques"       => $r->coso_eval_risques,
                "coso_env_controle"       => $r->coso_env_controle
            ];
        }

        echo json_encode([
            "success" => true,
            "data"    => $data
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        break;

    case 'modifier':
        $id = $_POST['id'] ?? null;
        if (!$id) {
            echo json_encode(["success" => false, "message" => "ID manquant"]);
            break;
        }

        $risque = new Risque(
            $_POST['titre'],
            $_POST['societe'],
            $_POST['categorie'],
            $_POST['statut'],
            $_POST['probabilite'],
            $_POST['impact'],
            $_POST['score'],
            $_POST['score_residuel'],
            $_POST['ctrl_type'],
            $_POST['ctrl_description'],
            $_POST['mitigate_strategy'],
            $_POST['mitigate_plan'],
            $_POST['mitigate_deadline'],
            $_POST['mitigate_owner'],
            $_POST['responsable'],
            $_POST['echeance'],
            $_POST['description'],
            $_POST['coso_pilotage'],
            $_POST['coso_info_comm'],
            $_POST['coso_activites_ctrl'],
            $_POST['coso_eval_risques'],
            $_POST['coso_env_controle'],
            (int) $id
        );

        $ok = $repo->modifier($risque);

        echo json_encode([
            "success" => $ok
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        break;

    case 'supprimer':
        $id = $_POST['id'] ?? null;
        if (!$id) {
            echo json_encode(["success" => false, "message" => "ID manquant"]);
            break;
        }

        $ok = $repo->supprimer((int) $id);

        echo json_encode([
            "success" => $ok
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        break;

    default:
        echo json_encode([
            "success" => false,
            "message" => "Action inconnue"
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
}