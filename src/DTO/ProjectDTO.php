<?php

namespace App\DTO;

class ProjectDTO
{
    public readonly ?string $id;
    public readonly ?string $name;

    public readonly ?\DateTimeInterface $createdAt;
    public readonly ?\DateTimeInterface $updatedAt;
    public readonly ?array $tasks;

    public function __construct(
        ?string $id,
        ?string $name,
        ?\DateTimeInterface $createdAt,
        ?\DateTimeInterface $updatedAt,
        ?array $tasks = null
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        if ($tasks !== null) {
            $this->tasks = $tasks;
        }
    }
}