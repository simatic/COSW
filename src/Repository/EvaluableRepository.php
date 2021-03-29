<?php

namespace App\Repository;

use App\Entity\Evaluable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Evaluable|null find($id, $lockMode = null, $lockVersion = null)
 * @method Evaluable|null findOneBy(array $criteria, array $orderBy = null)
 * @method Evaluable[]    findAll()
 * @method Evaluable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvaluableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Evaluable::class);
    }

    // /**
    //  * @return Evaluable[] Returns an array of Evaluable objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Evaluable
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
