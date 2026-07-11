<?php

require_once 'repository.php';
require_once 'auditeur.php';

header('Content-Type: application/json');

$action = $_POST['action'] ?? '';

$repo = new repository();

switch ($action) {
    case 'ajouter':
        $auditeur = new Auditeur(
            $_POST['nom'],
            $_POST['prenom'],
            $_POST['email'],
            $_POST['role'],
            $_POST['anciennete'],
            $_POST['specialisation'],
            $_POST['telephone'],
            $_POST['date_entree'],
            $_POST['statut'],
            $_POST['certifications']
        );

        $ok = $repo->ajouter($auditeur);

        echo json_encode([
            "success" => $ok,
            "id"      => $ok ? $auditeur->id : null,
        ]);
        break;

    case 'lister':
        $auditeurs = $repo->getAll();

        $data = [];

        foreach ($auditeurs as $a) {

            $data[] = [
                "id"            => $a->id,
                "nom"            => $a->nom,
                "prenom"         => $a->prenom,
                "email"          => $a->email,
                "role"           => $a->role,
                "anciennete"     => $a->anciennete,
                "specialisation" => $a->specialisation,
                "telephone"      => $a->telephone,
                "date_entree"    => $a->date_entree,
                "statut"         => $a->statut,
                "certifications" => $a->certifications
            ];

        }

        echo json_encode([
            "success" => true,
            "data" => $data
        ]);
        break;

    case 'modifier':
        $auditeur = new Auditeur(
            $_POST['nom'],
            $_POST['prenom'],
            $_POST['email'],
            $_POST['role'],
            $_POST['anciennete'],
            $_POST['specialisation'],
            $_POST['telephone'],
            $_POST['date_entree'],
            $_POST['statut'],
            $_POST['certifications']
        );

        $ok = $repo->modifier($auditeur);

        echo json_encode([
            "success" => $ok
        ]);
        break;

    case 'supprimer':
        $id = $_POST['id'];
        if(!$id){
            echo json_encode(["success" => false, "message" => "ID manquant"]);
            break;
        }
        $ok = $repo->supprimer((int)$id);

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