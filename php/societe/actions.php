<?php

require_once 'repository.php';
require_once 'Societe.php';

header('Content-Type: application/json');

$action = $_POST['action'] ?? '';

$repo = new repository();

switch ($action) {

    case 'ajouter':
        $societe = new Societe(
            $_POST['code'],
            $_POST['nom'],
            $_POST['secteur'],
            $_POST['pays'],
            $_POST['groupe'],
            $_POST['adresse'],
            $_POST['email'],
            $_POST['statut'],
            $_POST['notes']
        );

        $ok = $repo->ajouter($societe);

        echo json_encode([
            "success" => $ok
        ]);
        break;
    case 'lister':
        $societes = $repo->getAll();

        $data = [];

        foreach ($societes as $s) {

            $data[] = [
                "code"      => $s->code_societe,
                "nom"       => $s->nom_societe,
                "secteur"   => $s->secteur,
                "pays"      => $s->region,
                "groupe"     => $s->audit,
                "adresse"   => $s->adresse,
                "email"     => $s->email,
                "statut"    => $s->statut,
                "note"      => $s->note
            ];

        }

        echo json_encode([
            "success" => true,
            "data" => $data
        ]);
        break;
    case 'modifier':
        $societe = new Societe(
            $_POST['code'],
            $_POST['nom'],
            $_POST['secteur'],
            $_POST['pays'],
            $_POST['groupe'],
            $_POST['adresse'],
            $_POST['email'],
            $_POST['statut'],
            $_POST['notes']
        );


        $ok = $repo->modifier($societe);
        echo json_encode([
            "success" => $ok
        ]);
        break;
    case 'supprimer':
        $code = $_POST['code_societe'];
        $ok = $repo->supprimer($code);

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