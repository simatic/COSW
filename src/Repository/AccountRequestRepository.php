<?php

namespace App\Repository;

use App\Entity\AccountRequest;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AccountRequest|null find($id, $lockMode = null, $lockVersion = null)
 * @method AccountRequest|null findOneBy(array $criteria, array $orderBy = null)
 * @method AccountRequest[]    findAll()
 * @method AccountRequest[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AccountRequestRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AccountRequest::class);
    }

    // /**
    //  * @return AccountRequest[] Returns an array of AccountRequest objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AccountRequest
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
