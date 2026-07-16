<?php
header('Content-Type: application/json');

if (!isset($_POST['name']) || trim($_POST['name']) === '') {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Nom de fichier manquant.']);
    exit;
}

// Sécurité : on ne garde que le nom de base, pour empêcher toute remontée de dossier (../../)
$name = basename($_POST['name']);

$filePath = __DIR__ . '/fichiers/' . $name;

if (file_exists($filePath)) {
    if (unlink($filePath)) {
        echo json_encode(['success' => true]);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Impossible de supprimer le fichier.']);
    }
} else {
    // Le fichier n'existe déjà plus : on considère ça comme un succès
    echo json_encode(['success' => true, 'message' => 'Fichier déjà absent.']);
}