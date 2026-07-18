<?php

require_once 'repository.php'; // adapte le chemin/nom si Repository dédié à OrdreMission
require_once 'ordre_mission.php';

header('Content-Type: application/json');

$action = $_POST['action'] ?? '';

$repo = new Repository(); // ou OrdreMissionRepository si tu sépares

// Petit helper pour décoder les champs tableaux envoyés en JSON depuis le JS
function decodePostArray($key) {
    $raw = $_POST[$key] ?? [];

    // Cas 1 : déjà un tableau PHP (envoyé via jQuery en form-data classique, ex: equipe[]=...)
    if (is_array($raw)) {
        return $raw;
    }

    // Cas 2 : chaîne JSON (envoyée via JSON.stringify côté JS)
    $decoded = json_decode($raw, true);
    return is_array($decoded) ? $decoded : [];
}

// Construit un OrdreMission à partir des champs POST (utilisé par ajouter/modifier)
function buildOrdreMissionFromPost(?int $id = null): OrdreMission
{
    return new OrdreMission(
        $_POST['ref'] ?? '',
        $_POST['dateEmission'] ?? '',
        $_POST['statut'] ?? '',
        $_POST['objectifs'] ?? '',
        $_POST['perimetre'] ?? '',
        $_POST['referentiel'] ?? '',
        $_POST['travaux'] ?? '',
        $_POST['dateDebut'] ?? '',
        $_POST['dateFin'] ?? '',
        $_POST['duree'] ?? '',
        $_POST['lieu'] ?? '',
        $_POST['chefMission'] ?? '',
        $_POST['signataire'] ?? '',
        decodePostArray('equipe'),
        $_POST['notes'] ?? '',
        $_POST['typeControle'] ?? '',
        $_POST['risqueNiveau'] ?? '',
        decodePostArray('risquesCibles'),
        decodePostArray('assertions'),
        $_POST['methode'] ?? '',
        decodePostArray('taches'),
        $_POST['noteGlobale'] ?? '',
        $_POST['dateCloture'] ?? '',
        $_POST['constatations'] ?? '',
        $_POST['recommandationsOM'] ?? '',
        $_POST['conclusion'] ?? '',
        $_POST['ctrlRef'] ?? '',
        $_POST['ctrlDateEmission'] ?? '',
        $_POST['ctrlSociete'] ?? '',
        $_POST['ctrlType'] ?? '',
        $_POST['ctrlFrequence'] ?? '',
        $_POST['ctrlStatut'] ?? '',
        $_POST['ctrlObjet'] ?? '',
        decodePostArray('ctrlDomaines'),
        $_POST['ctrlRisque'] ?? '',
        $_POST['ctrlReferentiel'] ?? '',
        decodePostArray('ctrlCriteres'),
        $_POST['ctrlResponsable'] ?? '',
        decodePostArray('ctrlControleurs'),
        $_POST['ctrlSignataire'] ?? '',
        $_POST['ctrlInterlocuteur'] ?? '',
        $_POST['ctrlDateDebut'] ?? '',
        $_POST['ctrlDateFin'] ?? '',
        $_POST['ctrlDuree'] ?? '',
        $_POST['ctrlMethode'] ?? '',
        $_POST['ctrlEchantillon'] ?? '',
        $_POST['ctrlPeriode'] ?? '',
        decodePostArray('ctrlPoints'),
        $_POST['ctrlConclusionNiveau'] ?? '',
        $_POST['ctrlDateCloture'] ?? '',
        decodePostArray('ctrlEcarts'),
        decodePostArray('ctrlMesures'),
        $_POST['ctrlSynthese'] ?? '',
        $_POST['customTitre'] ?? '',
        $_POST['customIcone'] ?? '',
        $_POST['customCouleur'] ?? '#0070f2',
        $_POST['customSociete'] ?? '',
        $_POST['customDescription'] ?? '',
        decodePostArray('champPersonnalises'),
        $_POST['customSign1Label'] ?? '',
        $_POST['customSign1Nom'] ?? '',
        $_POST['customSign2Label'] ?? '',
        $_POST['customSign2Nom'] ?? '',
        $_POST['createdAt'] ?? '',
        $id
    );
}

switch ($action) {
    case 'ajouter':
        $mission = buildOrdreMissionFromPost();

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
                "id"                   => $m->id,
                "ref"                  => $m->ref,
                "dateEmission"         => $m->dateEmission,
                "statut"               => $m->statut,
                "objectifs"            => $m->objectifs,
                "perimetre"            => $m->perimetre,
                "referentiel"          => $m->referentiel,
                "travaux"              => $m->travaux,
                "dateDebut"            => $m->dateDebut,
                "dateFin"              => $m->dateFin,
                "duree"                => $m->duree,
                "lieu"                 => $m->lieu,
                "chefMission"          => $m->chefMission,
                "signataire"           => $m->signataire,
                "equipe"               => $m->equipe,
                "notes"                => $m->notes,
                "typeControle"         => $m->typeControle,
                "risqueNiveau"         => $m->risqueNiveau,
                "risquesCibles"        => $m->risquesCibles,
                "assertions"           => $m->assertions,
                "methode"              => $m->methode,
                "taches"               => $m->taches,
                "noteGlobale"          => $m->noteGlobale,
                "dateCloture"          => $m->dateCloture,
                "constatations"        => $m->constatations,
                "recommandationsOM"    => $m->recommandationsOM,
                "conclusion"           => $m->conclusion,
                "ctrlRef"              => $m->ctrlRef,
                "ctrlDateEmission"     => $m->ctrlDateEmission,
                "ctrlSociete"          => $m->ctrlSociete,
                "ctrlType"             => $m->ctrlType,
                "ctrlFrequence"        => $m->ctrlFrequence,
                "ctrlStatut"           => $m->ctrlStatut,
                "ctrlObjet"            => $m->ctrlObjet,
                "ctrlDomaines"         => $m->ctrlDomaines,
                "ctrlRisque"           => $m->ctrlRisque,
                "ctrlReferentiel"      => $m->ctrlReferentiel,
                "ctrlCriteres"         => $m->ctrlCriteres,
                "ctrlResponsable"      => $m->ctrlResponsable,
                "ctrlControleurs"      => $m->ctrlControleurs,
                "ctrlSignataire"       => $m->ctrlSignataire,
                "ctrlInterlocuteur"    => $m->ctrlInterlocuteur,
                "ctrlDateDebut"        => $m->ctrlDateDebut,
                "ctrlDateFin"          => $m->ctrlDateFin,
                "ctrlDuree"            => $m->ctrlDuree,
                "ctrlMethode"          => $m->ctrlMethode,
                "ctrlEchantillon"      => $m->ctrlEchantillon,
                "ctrlPeriode"          => $m->ctrlPeriode,
                "ctrlPoints"           => $m->ctrlPoints,
                "ctrlConclusionNiveau" => $m->ctrlConclusionNiveau,
                "ctrlDateCloture"      => $m->ctrlDateCloture,
                "ctrlEcarts"           => $m->ctrlEcarts,
                "ctrlMesures"          => $m->ctrlMesures,
                "ctrlSynthese"         => $m->ctrlSynthese,
                "customTitre"          => $m->customTitre,
                "customIcone"          => $m->customIcone,
                "customCouleur"        => $m->customCouleur,
                "customSociete"        => $m->customSociete,
                "customDescription"    => $m->customDescription,
                "champPersonnalises"   => $m->champPersonnalises,
                "customSign1Label"     => $m->customSign1Label,
                "customSign1Nom"       => $m->customSign1Nom,
                "customSign2Label"     => $m->customSign2Label,
                "customSign2Nom"       => $m->customSign2Nom,
                "createdAt"            => $m->createdAt,
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

        $mission = buildOrdreMissionFromPost((int) $id);

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