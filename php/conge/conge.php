<?php

class Conge
{
    public ?int $id;
    public string $auditeur;
    public string $debut;
    public string $fin;
    public string $hdebut;
    public string $hfin;
    public string $type;
    public string $statut;
    public string $note;

    public function __construct(
        $auditeur,
        $debut,
        $fin,
        $hdebut,
        $hfin,
        $type,
        $statut,
        $note,
        ?int $id = null
    ) {
        $this->id = $id;
        $this->auditeur = $auditeur;
        $this->debut = $debut;
        $this->fin = $fin;
        $this->hdebut = $hdebut;
        $this->hfin = $hfin;
        $this->type = $type;
        $this->statut = $statut;
        $this->note = $note;
    }
}