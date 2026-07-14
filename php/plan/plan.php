<?php

class Plan
{
    public ?int $id;
    public string $ref;
    public string $societe;
    public string $title;
    public string $debut;
    public string $fin;
    public string $contexte;
    public string $obj_general;
    public string $obj_specifiques;
    public string $services;
    public string $actual_start;
    public string $actual_end;
    public string $lieu;
    public string $debmois;
    public string $finmois;
    public string $debans;
    public string $finans;
    public string $fstatut;
    public string $fdifficulte;
    public string $cycle;
    public string $progress;
    public string $auditor;
    public string $fpointfort;
    public string $superviseur;
    public array $equipe;
    public string $risque;
    public string $statut;
    public string $ftype;
    public array $cycle_additionnel;
    public string $missionCategory;

    public function __construct(
        $ref,
        $societe,
        $title,
        $debut,
        $fin,
        $contexte,
        $obj_general,
        $obj_specifiques,
        $services,
        $actual_start,
        $actual_end,
        $lieu,
        $debmois,
        $finmois,
        $debans,
        $finans,
        $fpointfort,
        $fstatut,
        $fdifficulte,
        $cycle,
        $progress,
        $auditor,
        $superviseur,
        ? array $equipe,
        $risque,
        $statut,
        $ftype,
        ? array $cycle_additionnel,
        $missionCategory,
        ?int $id = null
        
    ) {
        $this->id = $id;
        $this->societe=$societe;
        $this->title=$title;
        $this->ref = $ref;
        $this->debut = $debut;
        $this->contexte = $contexte;
        $this->obj_general = $obj_general;
        $this->obj_specifiques = $obj_specifiques;
        $this->services = $services;
        $this->actual_start = $actual_start;
        $this->actual_end = $actual_end;
        $this->lieu = $lieu;
        $this->debmois = $debmois;
        $this->finmois = $finmois;
        $this->debans = $debans;
        $this->finans = $finans;
        $this->fpointfort = $fpointfort;
        $this->fstatut = $fstatut;
        $this->fdifficulte = $fdifficulte;
        $this->cycle = $cycle;
        $this->progress = $progress;
        $this->auditor = $auditor;
        $this->superviseur = $superviseur;
        $this->equipe = $equipe ?? [];
        $this->risque=$risque;
        $this->statut=$statut;
        $this->ftype=$ftype;
        $this->fin = $fin;
        $this->cycle_additionnel = $cycle_additionnel ?? [];
        $this->missionCategory=$missionCategory;
    }
}