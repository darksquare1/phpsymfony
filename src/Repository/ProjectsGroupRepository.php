<?php

namespace App\Repository;

use App\Entity\ProjectsGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

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

}
