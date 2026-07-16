<?php

class Taf
{
    public ?int $id;
    public string $categorie;
    public string $titre;
    public string $programme;
    public array $docs;
    public string $contact;
    public string $testplan;
    public string $testresults;
    public string $priorite;
    public string $statut;
    public string $auditeur;
    public string $notes;
    public array $societes_multi;
    public array $audit_refs;
    public array $fiches_test;
    public string $statut_updated_at;
    public string $updated_at;

    public function __construct(
        $categorie,
        $titre,
        $programme,
        ?array $docs,
        $contact,
        $testplan,
        $testresults,
        $priorite,
        $statut,
        $auditeur,
        $notes,
        $statut_updated_at,
        $updated_at,
        ?array $societes_multi,
        ?array $audit_refs,
        ?array $fiches_test,
        ?int $id = null
    ) {
        $this->id = $id;
        $this->categorie = $categorie;
        $this->titre = $titre;
        $this->programme = $programme;
        $this->docs = $docs ?? [];
        $this->contact = $contact;
        $this->testplan = $testplan;
        $this->testresults = $testresults;
        $this->priorite = $priorite;
        $this->statut = $statut;
        $this->auditeur = $auditeur;
        $this->notes = $notes;
        $this->societes_multi = $societes_multi ?? [];
        $this->audit_refs = $audit_refs ?? [];
        $this->fiches_test = $fiches_test ?? [];
        $this->statut_updated_at = $statut_updated_at;
         $this->updated_at = $updated_at;
    }
}