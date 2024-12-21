<?php

namespace App\DTO;

class ProjectGroupDTO
{
    public readonly ?string $id;
    public readonly ?string $name;
    public readonly ?\DateTimeInterface $createdAt;
    public readonly ?\DateTimeInterface $updatedAt;
    public readonly array $projects;

    public function __construct(
        ?string $id,
        ?string $name,
        ?\DateTimeInterface $createdAt,
        ?\DateTimeInterface $updatedAt,
        array $projects
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
        $this->projects = $projects;
    }
}