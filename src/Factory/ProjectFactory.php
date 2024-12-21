<?php

namespace App\Factory;

use App\DTO\ProjectDTO;
use App\Entity\Project;

class ProjectFactory
{
    private TaskFactory $taskFactory;

    public function __construct(TaskFactory $taskFactory)
    {
        $this->taskFactory = $taskFactory;
    }

    public function createFromEntity(Project $project, bool $includeRelatedData = true): ProjectDTO
    {
        if ($includeRelatedData) {
            $taskData = $this->taskFactory->createFromEntities($project->getTasks()->toArray(), false);
            $projectGroup = $project->getProjectsGroup();
            $projectGroupName = $projectGroup?->getName();
            $projectGroupId = $projectGroup?->getId();
            return new ProjectDTO(
                $project->getId(),
                $project->getName(),
                $project->getCreatedAt(),
                $project->getUpdatedAt(),
                $taskData,
                $projectGroupId,
                $projectGroupName
            );
        }

        return new ProjectDTO(
            $project->getId(),
            $project->getName(),
            $project->getCreatedAt(),
            $project->getUpdatedAt()
        );
    }

    public function createFromEntities(array $projects, bool $includeTasks = true): array
    {
        return array_map(fn(Project $project) => $this->createFromEntity($project, $includeTasks), $projects);
    }

}