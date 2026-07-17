<?php

require_once 'repository.php'; // adapte le chemin/nom si Repository dédié à TacheQuotidienne
require_once 'tache_quotidienne.php';
require_once 'tache_rapide.php';

header('Content-Type: application/json');

$action = $_POST['action'] ?? '';

$repo = new Repository(); // ou TacheQuotidienneRepository si tu sépares

// Petit helper pour décoder les champs tableaux envoyés en JSON depuis le JS
function decodePostArray($key) {
    $raw = $_POST[$key] ?? [];

    // Cas 1 : déjà un tableau PHP (envoyé via jQuery en form-data classique, ex: actions[]=...)
    if (is_array($raw)) {
        return $raw;
    }

    // Cas 2 : chaîne JSON (envoyée via JSON.stringify côté JS)
    $decoded = json_decode($raw, true);
    return is_array($decoded) ? $decoded : [];
}

// Helper : convertit une valeur POST (string "true"/"false"/"1"/"0") en booléen PHP
function decodePostBool($key) {
    $raw = $_POST[$key] ?? false;
    if (is_bool($raw)) return $raw;
    return filter_var($raw, FILTER_VALIDATE_BOOLEAN);
}

switch ($action) {
    case 'ajouter':
        $tache = new TacheQuotidienne(
            $_POST['titre'],
            $_POST['priorite'],
            $_POST['statut'],
            $_POST['date'],
            $_POST['responsable'],
            $_POST['societe'],
            $_POST['avancement'],
            $_POST['duree_heures'] ?? null,
            $_POST['notes'],
            decodePostBool('permanent'),
            $_POST['recurrenceType'] ?? '',
            decodePostArray('recurrenceDow'),
            decodePostArray('recurrenceDom'),
            decodePostArray('fiches_completion')
        );

        $ok = $repo->ajouter($tache);

        echo json_encode([
            "success" => $ok,
            "id"      => $ok ? $tache->id : null,
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        break;
    case 'modifier_rapide':
        $id = $_POST['id'] ?? null;
        $plan = new Tache_rapide(
            $_POST['avancement'],
            (int) $id
        );

        $ok = $repo->modifier_rapide($plan);

        echo json_encode([
            "success" => $ok
        ]);
        break;

    case 'lister':
        $taches = $repo->getAll();

        $data = [];
        foreach ($taches as $t) {
            $data[] = [
                "id"                => $t->id,
                "titre"             => $t->titre,
                "priorite"          => $t->priorite,
                "statut"            => $t->statut,
                "date"              => $t->date,
                "responsable"       => $t->responsable,
                "societe"           => $t->societe,
                "avancement"        => $t->avancement,
                "duree_heures"      => $t->duree_heures,
                "notes"             => $t->notes,
                "permanent"         => $t->permanent,
                "recurrenceType"    => $t->recurrenceType,
                "recurrenceDow"     => $t->recurrenceDow,
                "recurrenceDom"     => $t->recurrenceDom,
                "fiches_completion" => $t->fiches_completion,
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

        $tache = new TacheQuotidienne(
            $_POST['titre'],
            $_POST['priorite'],
            $_POST['statut'],
            $_POST['date'],
            $_POST['responsable'],
            $_POST['societe'],
            $_POST['avancement'],
            $_POST['duree_heures'] ?? null,
            $_POST['notes'],
            decodePostBool('permanent'),
            $_POST['recurrenceType'] ?? '',
            decodePostArray('recurrenceDow'),
            decodePostArray('recurrenceDom'),
            decodePostArray('fiches_completion'),
            (int) $id
        );

        $ok = $repo->modifier($tache);

        echo json_encode([
            "success" => $ok
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        break;
    case 'modifier_rapide':
        $id = $_POST['id'] ?? null;
        if (!$id) {
            echo json_encode(["success" => false, "message" => "ID manquant"]);
            break;
        }

        $tache = new Tache_rapide(
            $_POST['avancement'],
            (int) $id
        );

        $ok = $repo->modifier_rapide($tache);

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