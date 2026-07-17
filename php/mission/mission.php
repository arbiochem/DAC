<?php

class Mission
{
    public ?int $id;
    public string $ref;
    public string $title;
    public string $societe;
    public string $chef;
    public array $assignees;
    public string $start;
    public string $end;
    public int $progress;
    public string $status;
    public string $color;
    public array $tasks;

    public function __construct(
        $ref,
        $title,
        $societe,
        $chef,
        $assignees,
        $start,
        $end,
        $progress,
        $status,
        $color,
        $tasks,
        ?int $id = null
    ) {
        $this->id = $id;
        $this->ref =  $ref;
        $this->title = $title;
        $this->societe = $societe;
        $this->chef = $chef;
        $this->assignees = is_array($assignees) ? $assignees : [];
        $this->start = $start;
        $this->end = $end;
        $this->progress = (int) $progress;
        $this->status = $status;
        $this->color = $color;
        $this->tasks = is_array($tasks) ? $tasks : [];
    }
}