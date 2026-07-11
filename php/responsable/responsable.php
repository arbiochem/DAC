<?php

class Responsable
{
    public ?int $id;
    public string $nom;
    public string $prenom;
    public string $email;
    public string $fonction;
    public string $direction;
    public string $telephone;
    public string $statut;
    public string $nom_societe;

    public function __construct(
        string $nom,
        string $prenom,
        string $email,
        string $fonction,
        string $direction,
        string $telephone,
        string $statut,
        string $nom_societe,
        ?int $id = null
    ) {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->fonction = $fonction;
        $this->direction = $direction;
        $this->telephone = $telephone;
        $this->statut = $statut;
        $this->nom_societe = $nom_societe;
    }
}