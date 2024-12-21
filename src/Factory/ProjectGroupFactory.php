<?php

namespace App\Factory;

use App\DTO\ProjectGroupDTO;
use App\Entity\ProjectsGroup;

class ProjectGroupFactory
{

    private ProjectFactory $projectFactory;

    public function __construct(ProjectFactory $projectFactory)
    {
        $this->projectFactory = $projectFactory;
    }

    public function createFromEntity(ProjectsGroup $projectGroup): ProjectGroupDTO
    {
        $projectData = $this->projectFactory->createFromEntities($projectGroup->getProjects()->toArray(), false);

        return new ProjectGroupDTO(
            $projectGroup->getId(),
            $projectGroup->getName(),
            $projectGroup->getCreatedAt(),
            $projectGroup->getUpdatedAt(),
            $projectData,
        );
    }

    public function createFromEntities(array $projectGroups): array
    {
        return array_map(fn(ProjectsGroup $projectGroup) => $this->createFromEntity($projectGroup), $projectGroups);
    }

}