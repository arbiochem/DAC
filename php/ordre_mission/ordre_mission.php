<?php

class OrdreMission
{
    public ?int $id;
    public string $ref;
    public string $dateEmission;
    public string $statut;
    public string $objectifs;
    public string $perimetre;
    public string $referentiel;
    public string $travaux;
    public string $dateDebut;
    public string $dateFin;
    public string $duree;
    public string $lieu;
    public string $chefMission;
    public string $signataire;
    public array $equipe;
    public string $notes;
    public string $typeControle;
    public string $risqueNiveau;
    public array $risquesCibles;
    public array $assertions;
    public string $methode;
    public array $taches;
    public string $noteGlobale;
    public string $dateCloture;
    public string $constatations;
    public string $recommandationsOM;
    public string $conclusion;
    public string $ctrlRef;
    public string $ctrlDateEmission;
    public string $ctrlSociete;
    public string $ctrlType;
    public string $ctrlFrequence;
    public string $ctrlStatut;
    public string $ctrlObjet;
    public array $ctrlDomaines;
    public string $ctrlRisque;
    public string $ctrlReferentiel;
    public array $ctrlCriteres;
    public string $ctrlResponsable;
    public array $ctrlControleurs;
    public string $ctrlSignataire;
    public string $ctrlInterlocuteur;
    public string $ctrlDateDebut;
    public string $ctrlDateFin;
    public string $ctrlDuree;
    public string $ctrlMethode;
    public string $ctrlEchantillon;
    public string $ctrlPeriode;
    public array $ctrlPoints;
    public string $ctrlConclusionNiveau;
    public string $ctrlDateCloture;
    public array $ctrlEcarts;
    public array $ctrlMesures;
    public string $ctrlSynthese;
    public string $customTitre;
    public string $customIcone;
    public string $customCouleur;
    public string $customSociete;
    public string $customDescription;
    public array $champPersonnalises;
    public string $customSign1Label;
    public string $customSign1Nom;
    public string $customSign2Label;
    public string $customSign2Nom;
    public string $createdAt;

    public function __construct(
        $ref,
        $dateEmission,
        $statut,
        $objectifs,
        $perimetre,
        $referentiel,
        $travaux,
        $dateDebut,
        $dateFin,
        $duree,
        $lieu,
        $chefMission,
        $signataire,
        $equipe,
        $notes,
        $typeControle,
        $risqueNiveau,
        $risquesCibles,
        $assertions,
        $methode,
        $taches,
        $noteGlobale,
        $dateCloture,
        $constatations,
        $recommandationsOM,
        $conclusion,
        $ctrlRef,
        $ctrlDateEmission,
        $ctrlSociete,
        $ctrlType,
        $ctrlFrequence,
        $ctrlStatut,
        $ctrlObjet,
        $ctrlDomaines,
        $ctrlRisque,
        $ctrlReferentiel,
        $ctrlCriteres,
        $ctrlResponsable,
        $ctrlControleurs,
        $ctrlSignataire,
        $ctrlInterlocuteur,
        $ctrlDateDebut,
        $ctrlDateFin,
        $ctrlDuree,
        $ctrlMethode,
        $ctrlEchantillon,
        $ctrlPeriode,
        $ctrlPoints,
        $ctrlConclusionNiveau,
        $ctrlDateCloture,
        $ctrlEcarts,
        $ctrlMesures,
        $ctrlSynthese,
        $customTitre,
        $customIcone,
        $customCouleur,
        $customSociete,
        $customDescription,
        $champPersonnalises,
        $customSign1Label,
        $customSign1Nom,
        $customSign2Label,
        $customSign2Nom,
        $createdAt,
        ?int $id = null
    ) {
        $this->id = $id;
        $this->ref = $ref;
        $this->dateEmission = $dateEmission;
        $this->statut = $statut;
        $this->objectifs = $objectifs;
        $this->perimetre = $perimetre;
        $this->referentiel = $referentiel;
        $this->travaux = $travaux;
        $this->dateDebut = $dateDebut;
        $this->dateFin = $dateFin;
        $this->duree = $duree;
        $this->lieu = $lieu;
        $this->chefMission = $chefMission;
        $this->signataire = $signataire;
        $this->equipe = is_array($equipe) ? $equipe : [];
        $this->notes = $notes;
        $this->typeControle = $typeControle;
        $this->risqueNiveau = $risqueNiveau;
        $this->risquesCibles = is_array($risquesCibles) ? $risquesCibles : [];
        $this->assertions = is_array($assertions) ? $assertions : [];
        $this->methode = $methode;
        $this->taches = is_array($taches) ? $taches : [];
        $this->noteGlobale = $noteGlobale;
        $this->dateCloture = $dateCloture;
        $this->constatations = $constatations;
        $this->recommandationsOM = $recommandationsOM;
        $this->conclusion = $conclusion;
        $this->ctrlRef = $ctrlRef;
        $this->ctrlDateEmission = $ctrlDateEmission;
        $this->ctrlSociete = $ctrlSociete;
        $this->ctrlType = $ctrlType;
        $this->ctrlFrequence = $ctrlFrequence;
        $this->ctrlStatut = $ctrlStatut;
        $this->ctrlObjet = $ctrlObjet;
        $this->ctrlDomaines = is_array($ctrlDomaines) ? $ctrlDomaines : [];
        $this->ctrlRisque = $ctrlRisque;
        $this->ctrlReferentiel = $ctrlReferentiel;
        $this->ctrlCriteres = is_array($ctrlCriteres) ? $ctrlCriteres : [];
        $this->ctrlResponsable = $ctrlResponsable;
        $this->ctrlControleurs = is_array($ctrlControleurs) ? $ctrlControleurs : [];
        $this->ctrlSignataire = $ctrlSignataire;
        $this->ctrlInterlocuteur = $ctrlInterlocuteur;
        $this->ctrlDateDebut = $ctrlDateDebut;
        $this->ctrlDateFin = $ctrlDateFin;
        $this->ctrlDuree = $ctrlDuree;
        $this->ctrlMethode = $ctrlMethode;
        $this->ctrlEchantillon = $ctrlEchantillon;
        $this->ctrlPeriode = $ctrlPeriode;
        $this->ctrlPoints = is_array($ctrlPoints) ? $ctrlPoints : [];
        $this->ctrlConclusionNiveau = $ctrlConclusionNiveau;
        $this->ctrlDateCloture = $ctrlDateCloture;
        $this->ctrlEcarts = is_array($ctrlEcarts) ? $ctrlEcarts : [];
        $this->ctrlMesures = is_array($ctrlMesures) ? $ctrlMesures : [];
        $this->ctrlSynthese = $ctrlSynthese;
        $this->customTitre = $customTitre;
        $this->customIcone = $customIcone;
        $this->customCouleur = $customCouleur;
        $this->customSociete = $customSociete;
        $this->customDescription = $customDescription;
        $this->champPersonnalises = is_array($champPersonnalises) ? $champPersonnalises : [];
        $this->customSign1Label = $customSign1Label;
        $this->customSign1Nom = $customSign1Nom;
        $this->customSign2Label = $customSign2Label;
        $this->customSign2Nom = $customSign2Nom;
        $this->createdAt = $createdAt;
    }
}