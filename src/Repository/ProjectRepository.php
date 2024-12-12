<?php

namespace App\Repository;

use App\Entity\Project;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Uid\UuidV7;

/**
 * @extends ServiceEntityRepository<Project>
 *
 * @method Project|null find($id, $lockMode = null, $lockVersion = null)
 * @method Project|null findOneBy(array $criteria, array $orderBy = null)
 * @method Project[]    findAll()
 * @method Project[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Project::class);
    }


    public function findAllProjects(): array
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findAllWithRelations(): array
    {
        $projects = $this->findAll();
        $data = [];
        foreach ($projects as $project) {
            $tasks = $project->getTasks();
            $taskData = [];
            foreach ($tasks as $task) {
                $singleTaskInfo = [
                    'id' => $task->getId(),
                    'name' => $task->getName(),
                    'description' => $task->getDescription(),
                    'updated_at' => $task->getUpdatedAt(),
                    'created_at' => $task->getCreatedAt(),
                ];
                $taskData[] = $singleTaskInfo;
            }
            $data[] = [
                'id' => $project->getId(),
                'name' => $project->getName(),
                'createdAt' => $project->getCreatedAt(),
                'updatedAt' => $project->getUpdatedAt(),
                'tasks' => $taskData

            ];
        }

        return $data;
    }

    public function findOneByIdWithRelations(UuidV7 $id): array
    {
        $project = $this->find($id);
        $tasks = $project->getTasks();
        $taskData = [];
        foreach ($tasks as $task) {
            $singleTaskInfo = [
                'id' => $task->getId(),
                'name' => $task->getName(),
                'description' => $task->getDescription(),
                'updated_at' => $task->getUpdatedAt(),
                'created_at' => $task->getCreatedAt(),
            ];
            $taskData[] = $singleTaskInfo;
        }

        $data[] = [
            'id' => $project->getId(),
            'name' => $project->getName(),
            'createdAt' => $project->getCreatedAt(),
            'updatedAt' => $project->getUpdatedAt(),
            'tasks' => $taskData
        ];

        return $data;
    }
}
