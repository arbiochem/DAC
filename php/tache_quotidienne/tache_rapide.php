<?php

class Tache_rapide
{
    public string $avancement;
    public ?int $id;
    
    public function __construct(
        $avancement,
        ?int $id = null
    ) {
        $this->id = $id;
        $this->avancement=$avancement;
    }
}