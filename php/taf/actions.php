<?php

require_once 'repository.php'; // adapte le chemin/nom si Repository dédié à Taf
require_once 'taf.php';

header('Content-Type: application/json');

$action = $_POST['action'] ?? '';

$repo = new Repository(); // ou TafRepository si tu sépares

switch ($action) {
    case 'ajouter':
        $docs = json_decode($_POST['docs'] ?? '[]', true) ?? [];

        $societes_multi = $_POST['societes_multi'] ?? [];
        if (is_string($societes_multi)) {
            $societes_multi = json_decode($societes_multi, true) ?: [];
        }

        $audit_refs = $_POST['audit_refs'] ?? [];
        if (is_string($audit_refs)) {
            $audit_refs = json_decode($audit_refs, true) ?: [];
        }

        $fiches_test = $_POST['fiches_test'] ?? [];
        if (is_string($fiches_test)) {
            $fiches_test = json_decode($fiches_test, true) ?: [];
        }


        $taf = new Taf(
            $_POST['categorie'],
            $_POST['titre'],
            $_POST['programme'],
            $docs,
            $_POST['contact'],
            $_POST['testplan'],
            $_POST['testresults'],
            $_POST['priorite'],
            $_POST['statut'],
            $_POST['auditeur'],
            $_POST['notes'],
            $_POST['statut_updated_at'],
            $_POST['updated_at'],
            $societes_multi,   // <-- tableau décodé, plus $_POST direct
            $audit_refs,       // <-- idem
            $fiches_test
        );

        $ok = $repo->ajouter($taf);

        echo json_encode([
            "success" => $ok,
            "id"      => $ok ? $taf->id : null,
        ]);
        break;

    case 'lister':
        $tafs = $repo->getAll();

        $data = [];
        foreach ($tafs as $t) {
            $data[] = [
                "id"          => $t->id,
                "categorie"   => $t->categorie,
                "titre"       => $t->titre,
                "programme"   => $t->programme,
                "docs"        => $t->docs,
                "contact"     => $t->contact,
                "testplan"    => $t->testplan,
                "testresults" => $t->testresults,
                "priorite"    => $t->priorite,
                "statut"      => $t->statut,
                "auditeur"    => $t->auditeur,
                "notes"       => $t->notes,
                "updated_at"       => $t->updated_at,
                "societes_multi"       => $t->societes_multi,
                "audit_refs"       => $t->audit_refs,
                "fiches_test"       => $t->fiches_test
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

        $docs = json_decode($_POST['docs'] ?? '[]', true) ?? [];

        $societes_multi = $_POST['societes_multi'] ?? [];
        if (is_string($societes_multi)) {
            $societes_multi = json_decode($societes_multi, true) ?: [];
        }

        $audit_refs = $_POST['audit_refs'] ?? [];
        if (is_string($audit_refs)) {
            $audit_refs = json_decode($audit_refs, true) ?: [];
        }

        $fiches_test = $_POST['fiches_test'] ?? [];
        if (is_string($fiches_test)) {
            $fiches_test = json_decode($fiches_test, true) ?: [];
        }

        $taf = new Taf(
            $_POST['categorie'],
            $_POST['titre'],
            $_POST['programme'],
            $docs,
            $_POST['contact'],
            $_POST['testplan'],
            $_POST['testresults'],
            $_POST['priorite'],
            $_POST['statut'],
            $_POST['auditeur'],
            $_POST['notes'],
            $_POST['statut_updated_at'],
            $_POST['updated_at'],
            $societes_multi,
            $audit_refs,
            $fiches_test,
            (int) $id
        );

        $ok = $repo->modifier($taf);

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