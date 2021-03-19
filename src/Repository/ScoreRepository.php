<?php

namespace App\Repository;

use App\Entity\Score;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use  Doctrine\ORM\Tools\Pagination\Paginator;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator;

/**
 * @method Score|null find($id, $lockMode = null, $lockVersion = null)
 * @method Score|null findOneBy(array $criteria, array $orderBy = null)
 * @method Score[]    findAll()
 * @method Score[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ScoreRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Score::class);
    }

    // /**
    //  * @return Score[] Returns an array of Score objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Score
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
//



//$em = $this->getEntityManager();
//$query= $em->createQuery('select t from App\Entity\Score t
//
//        GROUP by t.id
// ORDER by count(t.id) DESC ');
//return $query->getResult();
//$stmt->execute();
//
//    // returns an array of arrays (i.e. a raw data set)
//return $stmt->fetchAll();
    //    $queryBuilder->select('t.score') // Here I use only the t.score, but you could put the whole class
//        ->from(Score::class, 'u')
//            ->orderBy('t.score', 'DESC LIMIT 2') ;
//    public function findRanks()
//    {
//        $conn = $this->getEntityManager()->getConnection();
//
//        $sql = 'SELECT  s.score
//  FROM
//  score s
// GROUP by s.score
// ORDER by count(s.score ) desc
// LIMIT 3';
//        $stmt = $conn->prepare($sql);
//
//        $stmt->execute();
//
//        // returns an array of arrays (i.e. a raw data set)
//        return $stmt->fetchAll();
//    }


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


}
