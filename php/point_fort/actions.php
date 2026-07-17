<?php

require_once 'repository.php';
require_once 'point_fort.php';

header('Content-Type: application/json');

$action = $_POST['action'] ?? '';

$repo = new Repository();

switch ($action) {

    case 'ajouter':
        $pointFort = new Point_fort(
            $_POST['auditRef'],
            $_POST['processus'],
            $_POST['pointFort'],
            $_POST['impact']
        );

        $ok = $repo->ajouter($pointFort);

        echo json_encode([
            "success" => $ok,
            "id"      => $ok ? $pointFort->id : null,
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        break;

    case 'lister':
        $pointsForts = $repo->getAll();

        $data = [];

        foreach ($pointsForts as $p) {
            $data[] = [
                "id"        => $p->id,
                "auditRef"  => $p->auditRef,
                "processus" => $p->processus,
                "pointFort" => $p->pointFort,
                "impact"    => $p->impact
            ];
        }

        echo json_encode([
            "success" => true,
            "data" => $data
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        break;

    case 'modifier':
        $id = $_POST['id'] ?? null;
        if (!$id) {
            echo json_encode(["success" => false, "message" => "ID manquant"]);
            break;
        }

        $pointFort = new Point_fort(
            $_POST['auditRef'],
            $_POST['processus'],
            $_POST['pointFort'],
            $_POST['impact'],
            (int) $id
        );

        $ok = $repo->modifier($pointFort);

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