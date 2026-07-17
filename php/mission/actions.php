<?php

require_once 'repository.php'; // adapte le chemin/nom si Repository dédié à Mission
require_once 'mission.php';

header('Content-Type: application/json');

$action = $_POST['action'] ?? '';

$repo = new Repository(); // ou MissionRepository si tu sépares

// Petit helper pour décoder les champs tableaux envoyés en JSON depuis le JS
function decodePostArray($key) {
    $raw = $_POST[$key] ?? [];

    // Cas 1 : déjà un tableau PHP (envoyé via jQuery en form-data classique, ex: assignees[]=...)
    if (is_array($raw)) {
        return $raw;
    }

    // Cas 2 : chaîne JSON (envoyée via JSON.stringify côté JS)
    $decoded = json_decode($raw, true);
    return is_array($decoded) ? $decoded : [];
}

switch ($action) {
    case 'ajouter':
        $mission = new Mission(
            $_POST['ref'] ?? '',
            $_POST['title'] ?? '',
            $_POST['societe'] ?? '',
            $_POST['chef'] ?? '',
            decodePostArray('assignees'),
            $_POST['start'] ?? '',
            $_POST['end'] ?? '',
            $_POST['progress'] ?? 0,
            $_POST['status'] ?? '',
            $_POST['color'] ?? '#0070f2',
            decodePostArray('tasks')
        );

        $ok = $repo->ajouter($mission);

        echo json_encode([
            "success" => $ok,
            "id"      => $ok ? $mission->id : null,
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        break;

    case 'lister':
        $missions = $repo->getAll();

        $data = [];
        foreach ($missions as $m) {
            $data[] = [
                "id"         => $m->id,
                "ref"        => $m->ref,
                "title"      => $m->title,
                "societe"    => $m->societe,
                "chef"       => $m->chef,
                "assignees"  => $m->assignees,
                "start"      => $m->start,
                "end"        => $m->end,
                "progress"   => $m->progress,
                "status"     => $m->status,
                "color"      => $m->color,
                "tasks"      => $m->tasks,
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

        $mission = new Mission(
            $_POST['ref'] ?? '',
            $_POST['title'] ?? '',
            $_POST['societe'] ?? '',
            $_POST['chef'] ?? '',
            decodePostArray('assignees'),
            $_POST['start'] ?? '',
            $_POST['end'] ?? '',
            $_POST['progress'] ?? 0,
            $_POST['status'] ?? '',
            $_POST['color'] ?? '#0070f2',
            decodePostArray('tasks'),
            (int) $id
        );

        $ok = $repo->modifier($mission);

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