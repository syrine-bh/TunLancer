<?php

namespace App\Repository;

use App\Entity\Concour;
use App\Entity\Quiz;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Concour|null find($id, $lockMode = null, $lockVersion = null)
 * @method Concour|null findOneBy(array $criteria, array $orderBy = null)
 * @method Concour[]    findAll()
 * @method Concour[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConcoursRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Concour::class);
    }

    // /**
    //  * @return Concour[] Returns an array of Concour objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Concour
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
//    public function FindByQuizId($id)
//    {
//        return $this->createQueryBuilder('q')
//            ->andWhere('q.quiz = :val')
//            ->setParameter('val', $id)
//            ->orderBy('q.quiz', 'ASC')
//            ->setMaxResults(100)
//            ->getQuery()
//            ->getResult();
//    }

    public function findByConcId($id)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.id = :val')
            ->setParameter('val', $id)
            ->orderBy('q.id', 'ASC')
            ->setMaxResults(100)
            ->getQuery()
            ->getResult()
            ;
    }
    public function FindByQuizId($id)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.quiz = :val')
            ->setParameter('val', $id)
            ->orderBy('q.quiz', 'ASC')
            ->setMaxResults(100)
            ->getQuery()
            ->getResult()
            ;
    }
    public function findQuiz ($id): ?Quiz {
        return $this
            ->createQueryBuilder('q')
            ->andWhere('q.id= :val')
            ->setParameter('val',$id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findConcourByNom($nom){
        return $this->createQueryBuilder('c')
            ->where('c.nom LIKE :nom')
            ->setParameter('nom', '%'.$nom.'%')
            ->getQuery()
            ->getResult();
    }
}
