<?php

require_once 'repository.php'; // adapte le chemin/nom si Repository dédié à Frap
require_once 'frap.php';

header('Content-Type: application/json');

$action = $_POST['action'] ?? '';

$repo = new Repository(); // ou FrapRepository si tu sépares

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

switch ($action) {
    case 'ajouter':
        $frap = new Frap(
            $_POST['numero'],
            $_POST['ref'],
            decodePostArray('audit_refs'),
            decodePostArray('taf_ref'),
            $_POST['titre'],
            $_POST['criticite'],
            $_POST['societe'],
            $_POST['cycle'],
            $_POST['auditeur'],
            $_POST['description'],
            $_POST['causes'],
            $_POST['consequences'],
            decodePostArray('recommandations'),
            decodePostArray('actions'),
            decodePostArray('preuves'),
            date('d/m/Y'),
            date('d/m/Y')// updated_at généré côté serveur à la création
        );

        $ok = $repo->ajouter($frap);

        echo json_encode([
            "success" => $ok,
            "id"      => $ok ? $frap->id : null,
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        break;

    case 'lister':
        $fraps = $repo->getAll();

        $data = [];
        foreach ($fraps as $f) {
            $data[] = [
                "id"              => $f->id,
                "numero"          => $f->numero,
                "ref"             => $f->ref,
                "audit_refs"      => $f->audit_refs,
                "taf_ref"         => $f->taf_ref,
                "titre"           => $f->titre,
                "criticite"       => $f->criticite,
                "societe"         => $f->societe,
                "cycle"           => $f->cycle,
                "auditeur"        => $f->auditeur,
                "description"     => $f->description,
                "causes"          => $f->causes,
                "consequences"    => $f->consequences,
                "recommandations" => $f->recommandations,
                "actions"         => $f->actions,
                "preuves"         => $f->preuves,
                "updated_at"      => $f->updated_at,
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

        $frap = new Frap(
            $_POST['numero'],
            $_POST['ref'],
            decodePostArray('audit_refs'),
            decodePostArray('taf_ref'),
            $_POST['titre'],
            $_POST['criticite'],
            $_POST['societe'],
            $_POST['cycle'],
            $_POST['auditeur'],
            $_POST['description'],
            $_POST['causes'],
            $_POST['consequences'],
            decodePostArray('recommandations'),
            decodePostArray('actions'),
            decodePostArray('preuves'),
            date('d/m/Y'), 
            date('d/m/Y'),
            (int) $id
        );

        $ok = $repo->modifier($frap);

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