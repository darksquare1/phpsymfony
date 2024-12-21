<?php

namespace App\Factory;

use App\DTO\TaskDTO;
use App\Entity\Task;

class TaskFactory
{
    public function createFromEntity(Task $task): TaskDTO
    {
        return new TaskDTO(
            $task->getId(),
            $task->getName(),
            $task->getDescription(),
            $task->getCreatedAt(),
            $task->getUpdatedAt()
        );
    }

    public function createFromEntities(array $tasks): array
    {
        return array_map(function (Task $task) {
            return $this->createFromEntity($task);
        }, $tasks);
    }
}
