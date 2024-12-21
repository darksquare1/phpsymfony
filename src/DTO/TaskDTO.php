<?php

namespace App\DTO;

class TaskDTO
{
    public readonly ?string $id;
    public readonly ?string $name;
    public readonly ?string $description;
    public readonly ?\DateTimeInterface $createdAt;
    public readonly ?\DateTimeInterface $updatedAt;

    public function __construct(
        ?string $id,
        ?string $name,
        ?string $description,
        ?\DateTimeInterface $createdAt,
        ?\DateTimeInterface $updatedAt)
    {
        $this->id = $id;
        $this->name = $name;
        $this->description = $description;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }
}