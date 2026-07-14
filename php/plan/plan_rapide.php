<?php

class Plan_rapide
{
    public string $ref;
    public string $fstatut;
    public string $progress;
    
    public function __construct(
        $ref,
        $fstatut,
        $progress
    ) {
        $this->ref = $ref;
        $this->fstatut = $fstatut;
        $this->progress=$progress;
    }
}