<?php

namespace App\Repository;

use App\Entity\QuestionConcour;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method QuestionConcour|null find($id, $lockMode = null, $lockVersion = null)
 * @method QuestionConcour|null findOneBy(array $criteria, array $orderBy = null)
 * @method QuestionConcour[]    findAll()
 * @method QuestionConcour[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionConcourRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, QuestionConcour::class);
    }

    // /**
    //  * @return QuestionConcour[] Returns an array of QuestionConcour objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('q.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?QuestionConcour
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
