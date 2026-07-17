<?php

class Point_fort
{
    public ?int $id;
    public string $auditRef;
    public string $processus;
    public string $pointFort;
    public string $impact;

    public function __construct(
        $auditRef,
        $processus,
        $pointFort,
        $impact,
        ?int $id = null
    ) {
        $this->id = $id;
        $this->auditRef = $auditRef;
        $this->processus = $processus;
        $this->pointFort = $pointFort;
        $this->impact = $impact;
    }
}