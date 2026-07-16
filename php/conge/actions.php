<?php

require_once 'repository.php';
require_once 'conge.php';

header('Content-Type: application/json');

$action = $_POST['action'] ?? '';

$repo = new Repository();

switch ($action) {

    case 'ajouter':
        $conge = new Conge(
            $_POST['auditeur'],
            $_POST['debut'],
            $_POST['fin'],
            $_POST['hdebut'],
            $_POST['hfin'],
            $_POST['type'],
            $_POST['statut'],
            $_POST['note']
        );

        $ok = $repo->ajouter($conge);

        echo json_encode([
            "success" => $ok,
            "id"      => $ok ? $conge->id : null,
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        break;

    case 'lister':
        $conges = $repo->getAll();

        $data = [];

        foreach ($conges as $c) {
            $data[] = [
                "id"       => $c->id,
                "auditeur" => $c->auditeur,
                "debut"    => $c->debut,
                "fin"      => $c->fin,
                "hdebut"   => $c->hdebut,
                "hfin"     => $c->hfin,
                "type"     => $c->type,
                "statut"   => $c->statut,
                "note"     => $c->note
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

        $conge = new Conge(
            $_POST['auditeur'],
            $_POST['debut'],
            $_POST['fin'],
            $_POST['hdebut'],
            $_POST['hfin'],
            $_POST['type'],
            $_POST['statut'],
            $_POST['note'],
            (int) $id
        );

        $ok = $repo->modifier($conge);

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