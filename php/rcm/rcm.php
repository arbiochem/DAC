<?php

class Rcm
{
    public ?int $id;
    public string $filiale;
    public string $ref;
    public string $cycle;
    public string $processus;
    public string $tache;
    public string $objectif;
    public string $risque;
    public string $imp_op;
    public string $imp_fin;
    public string $imp_rep;
    public float $impact;
    public float $likelihood;
    public float $inherent;
    public string $controle;
    public string $efficacite;
    public float $residuel;

    public function __construct(
        $filiale,
        $ref,
        $cycle,
        $processus,
        $tache,
        $objectif,
        $risque,
        $imp_op,
        $imp_fin,
        $imp_rep,
        $impact,
        $likelihood,
        $inherent,
        $controle,
        $efficacite,
        $residuel,
        ?int $id = null
    ) {
        $this->id = $id;
        $this->filiale = $filiale;
        $this->ref = $ref;
        $this->cycle = $cycle;
        $this->processus = $processus;
        $this->tache = $tache;
        $this->objectif = $objectif;
        $this->risque = $risque;
        $this->imp_op = $imp_op;
        $this->imp_fin = $imp_fin;
        $this->imp_rep = $imp_rep;
        $this->impact = (float) $impact;
        $this->likelihood = (float) $likelihood;
        $this->inherent = (float) $inherent;
        $this->controle = $controle;
        $this->efficacite = $efficacite;
        $this->residuel = (float) $residuel;
    }
}