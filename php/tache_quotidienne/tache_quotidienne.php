<?php

class TacheQuotidienne
{
    public ?int $id;
    public string $titre;
    public string $priorite;
    public string $statut;
    public string $date;
    public string $responsable;
    public string $societe;
    public int $avancement;
    public ?float $duree_heures;
    public string $notes;
    public bool $permanent;
    public string $recurrenceType;
    public array $recurrenceDow;
    public array $recurrenceDom;
    public array $fiches_completion;

    public function __construct(
        $titre,
        $priorite,
        $statut,
        $date,
        $responsable,
        $societe,
        $avancement,
        $duree_heures,
        $notes,
        $permanent,
        $recurrenceType,
        $recurrenceDow,
        $recurrenceDom,
        $fiches_completion,
        ?int $id = null
    ) {
        $this->id = $id;
        $this->titre = $titre;
        $this->priorite = $priorite;
        $this->statut = $statut;
        $this->date = $date;
        $this->responsable = $responsable;
        $this->societe = $societe;
        $this->avancement = (int) $avancement;
        $this->duree_heures = ($duree_heures === null || $duree_heures === '') ? null : (float) $duree_heures;
        $this->notes = $notes;
        $this->permanent = (bool) $permanent;
        $this->recurrenceType = $recurrenceType;
        $this->recurrenceDow = is_array($recurrenceDow) ? $recurrenceDow : [];
        $this->recurrenceDom = is_array($recurrenceDom) ? $recurrenceDom : [];
        $this->fiches_completion = is_array($fiches_completion) ? $fiches_completion : [];
    }
}