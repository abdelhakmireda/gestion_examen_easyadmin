<?php

namespace App\Repository;

use App\Entity\Filliere;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Filliere>
 *
 * @method Filliere|null find($id, $lockMode = null, $lockVersion = null)
 * @method Filliere|null findOneBy(array $criteria, array $orderBy = null)
 * @method Filliere[]    findAll()
 * @method Filliere[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FilliereRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Filliere::class);
    }

//    /**
//     * @return Filliere[] Returns an array of Filliere objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Filliere
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
