<?php

class Auditeur
{
    public ?int $id;
    public string $nom;
    public string $prenom;
    public string $email;
    public string $role;
    public string $anciennete;
    public string $specialisation;
    public string $telephone;
    public string $date_entree;
    public string $statut;
    public string $certifications;


    public function __construct(
        $nom,
        $prenom,
        $email,
        $role,
        $anciennete,
        $specialisation,
        $telephone,
        $date_entree,
        $statut,
        $certifications,
        ?int $id = null
    ) {
        $this->id = $id;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->email = $email;
        $this->role = $role;
        $this->anciennete = $anciennete;
        $this->specialisation = $specialisation;
        $this->telephone = $telephone;
        $this->date_entree = $date_entree;
        $this->statut = $statut;
        $this->certifications = $certifications;
    }
}