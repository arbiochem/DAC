<?php

class Frap
{
    public ?int $id;
    public string $numero;
    public string $ref;
    public array $audit_refs;
    public array $taf_ref;
    public string $titre;
    public string $criticite;
    public string $societe;
    public string $cycle;
    public string $auditeur;
    public string $description;
    public string $causes;
    public string $consequences;
    public array $recommandations;
    public array $actions;
    public array $preuves;
    public string $updated_at;
    public string $created_at;

    public function __construct(
        $numero,
        $ref,
        $audit_refs,
        $taf_ref,
        $titre,
        $criticite,
        $societe,
        $cycle,
        $auditeur,
        $description,
        $causes,
        $consequences,
        ?array $recommandations,
        ?array $actions,
        $preuves,
        $created_at,
        $updated_at,
        ?int $id = null
    ) {
        $this->id = $id;
        $this->numero = $numero;
        $this->ref = $ref;
        $this->audit_refs = is_array($audit_refs) ? $audit_refs : [];
        $this->taf_ref = is_array($taf_ref) ? $taf_ref : [];
        $this->titre = $titre;
        $this->criticite = $criticite;
        $this->societe = $societe;
        $this->cycle = $cycle;
        $this->auditeur = $auditeur;
        $this->description = $description;
        $this->causes = $causes;
        $this->consequences = $consequences;
        $this->recommandations = is_array($recommandations) ? $recommandations : [];
        $this->actions =is_array($actions) ? $actions : [];
        $this->preuves = is_array($preuves) ? $preuves : [];
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }
}