<?php

require_once 'repository.php'; // adapte le chemin/nom si Repository dédié à Rcm
require_once 'rcm.php';

header('Content-Type: application/json');

$action = $_POST['action'] ?? '';

$repo = new Repository(); // ou RcmRepository si tu sépares

switch ($action) {
    case 'ajouter':
        $rcm = new Rcm(
            $_POST['filiale'],
            $_POST['ref'],
            $_POST['cycle'],
            $_POST['processus'],
            $_POST['tache'],
            $_POST['objectif'],
            $_POST['risque'],
            $_POST['imp_op'],
            $_POST['imp_fin'],
            $_POST['imp_rep'],
            $_POST['impact'],
            $_POST['likelihood'],
            $_POST['inherent'],
            $_POST['controle'],
            $_POST['efficacite'],
            $_POST['residuel']
        );

        $ok = $repo->ajouter($rcm);

        echo json_encode([
            "success" => $ok,
            "id"      => $ok ? $rcm->id : null,
        ]);
        break;

    case 'lister':
        $rcms = $repo->getAll();

        $data = [];
        foreach ($rcms as $r) {
            $data[] = [
                "id"         => $r->id,
                "filiale"    => $r->filiale,
                "ref"        => $r->ref,
                "cycle"      => $r->cycle,
                "processus"  => $r->processus,
                "tache"      => $r->tache,
                "objectif"   => $r->objectif,
                "risque"     => $r->risque,
                "imp_op"     => $r->imp_op,
                "imp_fin"    => $r->imp_fin,
                "imp_rep"    => $r->imp_rep,
                "impact"     => $r->impact,
                "likelihood" => $r->likelihood,
                "inherent"   => $r->inherent,
                "controle"   => $r->controle,
                "efficacite" => $r->efficacite,
                "residuel"   => $r->residuel,
            ];
        }

        echo json_encode([
            "success" => true,
            "data"    => $data
        ]);
        break;

    case 'modifier':
        $ref = $_POST['ref'] ?? null;
        if (!$ref) {
            echo json_encode(["success" => false, "message" => "Référence manquante"]);
            break;
        }

        $rcm = new Rcm(
            $_POST['filiale'],
            $_POST['ref'],
            $_POST['cycle'],
            $_POST['processus'],
            $_POST['tache'],
            $_POST['objectif'],
            $_POST['risque'],
            $_POST['imp_op'],
            $_POST['imp_fin'],
            $_POST['imp_rep'],
            $_POST['impact'],
            $_POST['likelihood'],
            $_POST['inherent'],
            $_POST['controle'],
            $_POST['efficacite'],
            $_POST['residuel']
        );

        $ok = $repo->modifier($rcm);

        echo json_encode([
            "success" => $ok
        ]);
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
        ]);
        break;

    default:
        echo json_encode([
            "success" => false,
            "message" => "Action inconnue"
        ]);
}