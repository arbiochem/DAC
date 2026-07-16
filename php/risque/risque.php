<?php

class Risque
{
    public ?int $id;
    public string $titre;
    public string $societe;
    public string $categorie;
    public string $statut;
    public float $probabilite;
    public float $impact;
    public float $score;
    public float $score_residuel;
    public string $ctrl_type;
    public string $ctrl_description;
    public string $mitigate_strategy;
    public string $mitigate_plan;
    public string $mitigate_deadline;
    public string $mitigate_owner;
    public string $responsable;
    public string $echeance;
    public string $description;
    public string $coso_pilotage;
    public string $coso_info_comm;
    public string $coso_activites_ctrl;
    public string $coso_eval_risques;
    public string $coso_env_controle;

    public function __construct(
        $titre,
        $societe,
        $categorie,
        $statut,
        $probabilite,
        $impact,
        $score,
        $score_residuel,
        $ctrl_type,
        $ctrl_description,
        $mitigate_strategy,
        $mitigate_plan,
        $mitigate_deadline,
        $mitigate_owner,
        $responsable,
        $echeance,
        $description,
        $coso_pilotage,
        $coso_info_comm,
        $coso_activites_ctrl,
        $coso_eval_risques,
        $coso_env_controle,
        ?int $id = null
    ) {
        $this->id = $id;
        $this->titre = $titre;
        $this->societe = $societe;
        $this->categorie = $categorie;
        $this->statut = $statut;
        $this->probabilite = (float) $probabilite;
        $this->impact = (float) $impact;
        $this->score = (float) $score;
        $this->score_residuel = (float) $score_residuel;
        $this->ctrl_type = $ctrl_type;
        $this->ctrl_description = $ctrl_description;
        $this->mitigate_strategy = $mitigate_strategy;
        $this->mitigate_plan = $mitigate_plan;
        $this->mitigate_deadline = $mitigate_deadline;
        $this->mitigate_owner = $mitigate_owner;
        $this->responsable = $responsable;
        $this->echeance = $echeance;
        $this->description = $description;
        $this->coso_pilotage = $coso_pilotage;
        $this->coso_info_comm = $coso_info_comm;
        $this->coso_activites_ctrl = $coso_activites_ctrl;
        $this->coso_eval_risques = $coso_eval_risques;
        $this->coso_env_controle = $coso_env_controle;
    }
}