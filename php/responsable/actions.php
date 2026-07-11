<?php

require_once 'repository.php';
require_once 'responsable.php';

header('Content-Type: application/json');

$action = $_POST['action'] ?? '';

$repo = new Repository();

switch ($action) {
    case 'ajouter':
        $responsable = new Responsable(
            $_POST['nom'],
            $_POST['prenom'],
            $_POST['email'],
            $_POST['fonction'],
            $_POST['direction'],
            $_POST['telephone'],
            $_POST['statut'],
            $_POST['nom_societe']
        );

        $ok = $repo->ajouter($responsable);

        echo json_encode([
            "success" => $ok,
            "id"      => $ok ? $responsable->id : null,
        ]);
        break;

    case 'lister':
        $responsables = $repo->getAll();

        $data = [];

        foreach ($responsables as $r) {
            $data[] = [
                "id"          => $r->id,
                "nom"         => $r->nom,
                "prenom"      => $r->prenom,
                "email"       => $r->email,
                "fonction"    => $r->fonction,
                "direction"   => $r->direction,
                "telephone"   => $r->telephone,
                "statut"      => $r->statut,
                "nom_societe" => $r->nom_societe,
            ];
        }

        echo json_encode([
            "success" => true,
            "data" => $data
        ]);
        break;

    case 'modifier':
        if (empty($_POST['id'])) {
            echo json_encode(["success" => false, "message" => "ID manquant"]);
            break;
        }

        $responsable = new Responsable(
            $_POST['nom'],
            $_POST['prenom'],
            $_POST['email'],
            $_POST['fonction'],
            $_POST['direction'],
            $_POST['telephone'],
            $_POST['statut'],
            $_POST['nom_societe'],
            (int) $_POST['id']
        );

        $ok = $repo->modifier($responsable);

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