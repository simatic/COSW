<?php

namespace App\Repository;

use App\Entity\EvalItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method EvalItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method EvalItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method EvalItem[]    findAll()
 * @method EvalItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvalItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EvalItem::class);
    }

    // /**
    //  * @return EvalItem[] Returns an array of EvalItem objects
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
    public function findOneBySomeField($value): ?EvalItem
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
