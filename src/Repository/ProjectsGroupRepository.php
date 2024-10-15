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

//    /**
//     * @return ProjectsGroup[] Returns an array of ProjectsGroup objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ProjectsGroup
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
