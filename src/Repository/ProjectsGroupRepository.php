<?php

namespace App\Repository;

use App\Entity\ProjectsGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\Uuid;

/**
 * @extends ServiceEntityRepository<ProjectsGroup>
 *
 * @method ProjectsGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProjectsGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProjectsGroup[]    findAll()
 * @method ProjectsGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectsGroupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProjectsGroup::class);
    }

    public function findAllWithRelations(): array
    {
        $projectGroups = $this->findAll();
        $data = [];
        foreach ($projectGroups as $projectGroup) {
            $projects = $projectGroup->getProjects();
            $projectData = [];
            foreach ($projects as $project) {
                $singleProjectInfo = [
                    'id' => $project->getId(),
                    'name' => $project->getName(),
                    'updated_at' => $project->getUpdatedAt(),
                    'created_at' => $project->getCreatedAt(),
                ];
                $projectData[] = $singleProjectInfo;
            }
            $data[] = [
                'id' => $projectGroup->getId(),
                'name' => $projectGroup->getName(),
                'createdAt' => $projectGroup->getCreatedAt(),
                'updatedAt' => $projectGroup->getUpdatedAt(),
                'projects' => $projectData,
            ];
        }

        return $data;
    }

    public function findOneByIdWithRelations(Uuid $id): array
    {
        $projectGroup = $this->find($id);
        $projects = $projectGroup->getProjects();
        $projectData = [];
        foreach ($projects as $project) {
            $singleProjectInfo = [
                'id' => $project->getId(),
                'name' => $project->getName(),
                'updated_at' => $project->getUpdatedAt(),
                'created_at' => $project->getCreatedAt(),
            ];
            $projectData[] = $singleProjectInfo;
        }

        $data[] = [
            'id' => $projectGroup->getId(),
            'name' => $projectGroup->getName(),
            'createdAt' => $projectGroup->getCreatedAt(),
            'updatedAt' => $projectGroup->getUpdatedAt(),
            'projects' => $projectData,
        ];

        return $data;
    }
}
