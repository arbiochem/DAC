<?php

class Societe
{
    public string $code_societe;
    public string $nom_societe;
    public string $secteur;
    public string $region;
    public string $audit;
    public string $adresse;
    public string $email;
    public string $statut;
    public string $note;

    public function __construct(
        $code_societe,
        $nom_societe,
        $secteur,
        $region,
        $audit,
        $adresse,
        $email,
        $statut,
        $note
    ) {
        $this->code_societe = $code_societe;
        $this->nom_societe = $nom_societe;
        $this->secteur = $secteur;
        $this->region = $region;
        $this->audit = $audit;
        $this->adresse = $adresse;
        $this->email = $email;
        $this->statut = $statut;
        $this->note = $note;
    }
}