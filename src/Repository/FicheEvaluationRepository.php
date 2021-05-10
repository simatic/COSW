<?php

namespace App\Repository;

use App\Entity\FicheEvaluation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FicheEvaluation|null find($id, $lockMode = null, $lockVersion = null)
 * @method FicheEvaluation|null findOneBy(array $criteria, array $orderBy = null)
 * @method FicheEvaluation[]    findAll()
 * @method FicheEvaluation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FicheEvaluationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FicheEvaluation::class);
    }

    // /**
    //  * @return FicheEvaluation[] Returns an array of FicheEvaluation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FicheEvaluation
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
