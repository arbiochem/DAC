<?php
// error_reporting(E_ALL);      ← à retirer/commenter
// ini_set('display_errors', 1); ← à retirer/commenter
// var_dump($_FILES);            ← À SUPPRIMER, c'est lui qui casse tout

$dossierDestination = __DIR__ . '/fichiers/';

if (!is_dir($dossierDestination)) {
    mkdir($dossierDestination, 0755, true);
}

$resultats = [];

if (!empty($_FILES['fichiers'])) {
    $fichiers = $_FILES['fichiers'];
    $nombreFichiers = count($fichiers['name']);

    for ($i = 0; $i < $nombreFichiers; $i++) {
        if ($fichiers['error'][$i] !== UPLOAD_ERR_OK) {
            $resultats[] = ['nom' => $fichiers['name'][$i], 'statut' => 'erreur'];
            continue;
        }

        $nomOriginal = basename($fichiers['name'][$i]);
        $nomSecurise = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $nomOriginal);
        $cheminFinal = $dossierDestination . $nomSecurise;

        if (move_uploaded_file($fichiers['tmp_name'][$i], $cheminFinal)) {
            $resultats[] = ['nom' => $nomSecurise, 'statut' => 'ok'];
        } else {
            $resultats[] = ['nom' => $nomSecurise, 'statut' => 'erreur'];
        }
    }
}

header('Content-Type: application/json');
echo json_encode($resultats);