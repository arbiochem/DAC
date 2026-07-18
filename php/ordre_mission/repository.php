<?php

require_once __DIR__ . '/../Database.php';
require_once __DIR__ . '/ordre_mission.php';

class Repository {
    private PDO $db;

    // Champs de la table à décoder en tableau JSON (equipe[], taches[], etc.)
    private const ARRAY_FIELDS = [
        'equipe',
        'risquesCibles',
        'assertions',
        'taches',
        'ctrlDomaines',
        'ctrlCriteres',
        'ctrlControleurs',
        'ctrlPoints',
        'ctrlEcarts',
        'ctrlMesures',
        'champPersonnalises',
    ];

    public function __construct() {
        $this->db = Database::getInstance()->getConnexion();
    }

    // CREATE : ajouter un ordre de mission
    public function ajouter(OrdreMission $mission): bool {
        $sql = "INSERT INTO ordres_mission (
                    ref, dateEmission, statut, objectifs, perimetre, referentiel, travaux,
                    dateDebut, dateFin, duree, lieu, chefMission, signataire, equipe, notes,
                    typeControle, risqueNiveau, risquesCibles, assertions, methode, taches,
                    noteGlobale, dateCloture, constatations, recommandationsOM, conclusion,
                    ctrlRef, ctrlDateEmission, ctrlSociete, ctrlType, ctrlFrequence, ctrlStatut,
                    ctrlObjet, ctrlDomaines, ctrlRisque, ctrlReferentiel, ctrlCriteres,
                    ctrlResponsable, ctrlControleurs, ctrlSignataire, ctrlInterlocuteur,
                    ctrlDateDebut, ctrlDateFin, ctrlDuree, ctrlMethode, ctrlEchantillon,
                    ctrlPeriode, ctrlPoints, ctrlConclusionNiveau, ctrlDateCloture, ctrlEcarts,
                    ctrlMesures, ctrlSynthese, customTitre, customIcone, customCouleur,
                    customSociete, customDescription, champPersonnalises, customSign1Label,
                    customSign1Nom, customSign2Label, customSign2Nom, createdAt
                ) VALUES (
                    :ref, :dateEmission, :statut, :objectifs, :perimetre, :referentiel, :travaux,
                    :dateDebut, :dateFin, :duree, :lieu, :chefMission, :signataire, :equipe, :notes,
                    :typeControle, :risqueNiveau, :risquesCibles, :assertions, :methode, :taches,
                    :noteGlobale, :dateCloture, :constatations, :recommandationsOM, :conclusion,
                    :ctrlRef, :ctrlDateEmission, :ctrlSociete, :ctrlType, :ctrlFrequence, :ctrlStatut,
                    :ctrlObjet, :ctrlDomaines, :ctrlRisque, :ctrlReferentiel, :ctrlCriteres,
                    :ctrlResponsable, :ctrlControleurs, :ctrlSignataire, :ctrlInterlocuteur,
                    :ctrlDateDebut, :ctrlDateFin, :ctrlDuree, :ctrlMethode, :ctrlEchantillon,
                    :ctrlPeriode, :ctrlPoints, :ctrlConclusionNiveau, :ctrlDateCloture, :ctrlEcarts,
                    :ctrlMesures, :ctrlSynthese, :customTitre, :customIcone, :customCouleur,
                    :customSociete, :customDescription, :champPersonnalises, :customSign1Label,
                    :customSign1Nom, :customSign2Label, :customSign2Nom, :createdAt
                )";

        $stmt = $this->db->prepare($sql);
        $success = $stmt->execute($this->toParams($mission));

        if ($success) {
            $mission->id = (int) $this->db->lastInsertId();
        }

        return $success;
    }

    // READ : récupérer tous les ordres de mission
    public function getAll(): array {
        $stmt = $this->db->query("SELECT * FROM ordres_mission");
        $resultats = $stmt->fetchAll();

        $missions = [];
        foreach ($resultats as $ligne) {
            $missions[] = $this->hydrate($ligne);
        }
        return $missions;
    }

    // READ : récupérer un ordre de mission par son id
    public function getById(int $id): ?OrdreMission {
        $sql = "SELECT * FROM ordres_mission WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $ligne = $stmt->fetch();

        if (!$ligne) {
            return null;
        }

        return $this->hydrate($ligne);
    }

    // UPDATE : mettre à jour un ordre de mission
    public function modifier(OrdreMission $mission): bool {
        $sql = "UPDATE ordres_mission SET
            ref=:ref,
            dateEmission=:dateEmission,
            statut=:statut,
            objectifs=:objectifs,
            perimetre=:perimetre,
            referentiel=:referentiel,
            travaux=:travaux,
            dateDebut=:dateDebut,
            dateFin=:dateFin,
            duree=:duree,
            lieu=:lieu,
            chefMission=:chefMission,
            signataire=:signataire,
            equipe=:equipe,
            notes=:notes,
            typeControle=:typeControle,
            risqueNiveau=:risqueNiveau,
            risquesCibles=:risquesCibles,
            assertions=:assertions,
            methode=:methode,
            taches=:taches,
            noteGlobale=:noteGlobale,
            dateCloture=:dateCloture,
            constatations=:constatations,
            recommandationsOM=:recommandationsOM,
            conclusion=:conclusion,
            ctrlRef=:ctrlRef,
            ctrlDateEmission=:ctrlDateEmission,
            ctrlSociete=:ctrlSociete,
            ctrlType=:ctrlType,
            ctrlFrequence=:ctrlFrequence,
            ctrlStatut=:ctrlStatut,
            ctrlObjet=:ctrlObjet,
            ctrlDomaines=:ctrlDomaines,
            ctrlRisque=:ctrlRisque,
            ctrlReferentiel=:ctrlReferentiel,
            ctrlCriteres=:ctrlCriteres,
            ctrlResponsable=:ctrlResponsable,
            ctrlControleurs=:ctrlControleurs,
            ctrlSignataire=:ctrlSignataire,
            ctrlInterlocuteur=:ctrlInterlocuteur,
            ctrlDateDebut=:ctrlDateDebut,
            ctrlDateFin=:ctrlDateFin,
            ctrlDuree=:ctrlDuree,
            ctrlMethode=:ctrlMethode,
            ctrlEchantillon=:ctrlEchantillon,
            ctrlPeriode=:ctrlPeriode,
            ctrlPoints=:ctrlPoints,
            ctrlConclusionNiveau=:ctrlConclusionNiveau,
            ctrlDateCloture=:ctrlDateCloture,
            ctrlEcarts=:ctrlEcarts,
            ctrlMesures=:ctrlMesures,
            ctrlSynthese=:ctrlSynthese,
            customTitre=:customTitre,
            customIcone=:customIcone,
            customCouleur=:customCouleur,
            customSociete=:customSociete,
            customDescription=:customDescription,
            champPersonnalises=:champPersonnalises,
            customSign1Label=:customSign1Label,
            customSign1Nom=:customSign1Nom,
            customSign2Label=:customSign2Label,
            customSign2Nom=:customSign2Nom,
            createdAt=:createdAt
        WHERE id = :id";

        $stmt = $this->db->prepare($sql);

        $params = $this->toParams($mission);
        $params['id'] = $mission->id;

        return $stmt->execute($params);
    }

    // DELETE : supprimer un ordre de mission
    public function supprimer(int $id): bool {
        $sql = "DELETE FROM ordres_mission WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    // Mise à jour rapide (ex: changement de statut seul, sans repasser tous les champs)
    public function modifierStatut(int $id, string $statut): bool {
        $sql = "UPDATE ordres_mission SET statut = :statut WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'statut' => $statut,
            'id'     => $id,
        ]);
    }

    private function decodeArrayField($value) {
        if (is_array($value)) return $value;
        $decoded = json_decode($value, true);
        return is_array($decoded) ? $decoded : [];
    }

    // Construit un objet OrdreMission à partir d'une ligne de résultat SQL
    private function hydrate(array $ligne): OrdreMission {
        return new OrdreMission(
            $ligne['ref'],
            $ligne['dateEmission'],
            $ligne['statut'],
            $ligne['objectifs'],
            $ligne['perimetre'],
            $ligne['referentiel'],
            $ligne['travaux'],
            $ligne['dateDebut'],
            $ligne['dateFin'],
            $ligne['duree'],
            $ligne['lieu'],
            $ligne['chefMission'],
            $ligne['signataire'],
            $this->decodeArrayField($ligne['equipe']),
            $ligne['notes'],
            $ligne['typeControle'],
            $ligne['risqueNiveau'],
            $this->decodeArrayField($ligne['risquesCibles']),
            $this->decodeArrayField($ligne['assertions']),
            $ligne['methode'],
            $this->decodeArrayField($ligne['taches']),
            $ligne['noteGlobale'],
            $ligne['dateCloture'],
            $ligne['constatations'],
            $ligne['recommandationsOM'],
            $ligne['conclusion'],
            $ligne['ctrlRef'],
            $ligne['ctrlDateEmission'],
            $ligne['ctrlSociete'],
            $ligne['ctrlType'],
            $ligne['ctrlFrequence'],
            $ligne['ctrlStatut'],
            $ligne['ctrlObjet'],
            $this->decodeArrayField($ligne['ctrlDomaines']),
            $ligne['ctrlRisque'],
            $ligne['ctrlReferentiel'],
            $this->decodeArrayField($ligne['ctrlCriteres']),
            $ligne['ctrlResponsable'],
            $this->decodeArrayField($ligne['ctrlControleurs']),
            $ligne['ctrlSignataire'],
            $ligne['ctrlInterlocuteur'],
            $ligne['ctrlDateDebut'],
            $ligne['ctrlDateFin'],
            $ligne['ctrlDuree'],
            $ligne['ctrlMethode'],
            $ligne['ctrlEchantillon'],
            $ligne['ctrlPeriode'],
            $this->decodeArrayField($ligne['ctrlPoints']),
            $ligne['ctrlConclusionNiveau'],
            $ligne['ctrlDateCloture'],
            $this->decodeArrayField($ligne['ctrlEcarts']),
            $this->decodeArrayField($ligne['ctrlMesures']),
            $ligne['ctrlSynthese'],
            $ligne['customTitre'],
            $ligne['customIcone'],
            $ligne['customCouleur'],
            $ligne['customSociete'],
            $ligne['customDescription'],
            $this->decodeArrayField($ligne['champPersonnalises']),
            $ligne['customSign1Label'],
            $ligne['customSign1Nom'],
            $ligne['customSign2Label'],
            $ligne['customSign2Nom'],
            $ligne['createdAt'],
            $ligne['id']
        );
    }

    // Construit le tableau de paramètres pour les requêtes préparées
    private function toParams(OrdreMission $mission): array {
        $params = [
            'ref'                  => $mission->ref,
            'dateEmission'         => $mission->dateEmission,
            'statut'               => $mission->statut,
            'objectifs'            => $mission->objectifs,
            'perimetre'            => $mission->perimetre,
            'referentiel'          => $mission->referentiel,
            'travaux'              => $mission->travaux,
            'dateDebut'            => $mission->dateDebut,
            'dateFin'              => $mission->dateFin,
            'duree'                => $mission->duree,
            'lieu'                 => $mission->lieu,
            'chefMission'          => $mission->chefMission,
            'signataire'           => $mission->signataire,
            'equipe'               => $mission->equipe,
            'notes'                => $mission->notes,
            'typeControle'         => $mission->typeControle,
            'risqueNiveau'         => $mission->risqueNiveau,
            'risquesCibles'        => $mission->risquesCibles,
            'assertions'           => $mission->assertions,
            'methode'              => $mission->methode,
            'taches'               => $mission->taches,
            'noteGlobale'          => $mission->noteGlobale,
            'dateCloture'          => $mission->dateCloture,
            'constatations'        => $mission->constatations,
            'recommandationsOM'    => $mission->recommandationsOM,
            'conclusion'           => $mission->conclusion,
            'ctrlRef'              => $mission->ctrlRef,
            'ctrlDateEmission'     => $mission->ctrlDateEmission,
            'ctrlSociete'          => $mission->ctrlSociete,
            'ctrlType'             => $mission->ctrlType,
            'ctrlFrequence'        => $mission->ctrlFrequence,
            'ctrlStatut'           => $mission->ctrlStatut,
            'ctrlObjet'            => $mission->ctrlObjet,
            'ctrlDomaines'         => $mission->ctrlDomaines,
            'ctrlRisque'           => $mission->ctrlRisque,
            'ctrlReferentiel'      => $mission->ctrlReferentiel,
            'ctrlCriteres'         => $mission->ctrlCriteres,
            'ctrlResponsable'      => $mission->ctrlResponsable,
            'ctrlControleurs'      => $mission->ctrlControleurs,
            'ctrlSignataire'       => $mission->ctrlSignataire,
            'ctrlInterlocuteur'    => $mission->ctrlInterlocuteur,
            'ctrlDateDebut'        => $mission->ctrlDateDebut,
            'ctrlDateFin'          => $mission->ctrlDateFin,
            'ctrlDuree'            => $mission->ctrlDuree,
            'ctrlMethode'          => $mission->ctrlMethode,
            'ctrlEchantillon'      => $mission->ctrlEchantillon,
            'ctrlPeriode'          => $mission->ctrlPeriode,
            'ctrlPoints'           => $mission->ctrlPoints,
            'ctrlConclusionNiveau' => $mission->ctrlConclusionNiveau,
            'ctrlDateCloture'      => $mission->ctrlDateCloture,
            'ctrlEcarts'           => $mission->ctrlEcarts,
            'ctrlMesures'          => $mission->ctrlMesures,
            'ctrlSynthese'         => $mission->ctrlSynthese,
            'customTitre'          => $mission->customTitre,
            'customIcone'          => $mission->customIcone,
            'customCouleur'        => $mission->customCouleur,
            'customSociete'        => $mission->customSociete,
            'customDescription'    => $mission->customDescription,
            'champPersonnalises'   => $mission->champPersonnalises,
            'customSign1Label'     => $mission->customSign1Label,
            'customSign1Nom'       => $mission->customSign1Nom,
            'customSign2Label'     => $mission->customSign2Label,
            'customSign2Nom'       => $mission->customSign2Nom,
            'createdAt'            => $mission->createdAt,
        ];

        // Encode en JSON tous les champs tableau avant insertion/mise à jour
        foreach (self::ARRAY_FIELDS as $champ) {
            $params[$champ] = json_encode($params[$champ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        }

        return $params;
    }
}