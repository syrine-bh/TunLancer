<?php

namespace App\Repository;

use App\Entity\Topics;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Topics|null find($id, $lockMode = null, $lockVersion = null)
 * @method Topics|null findOneBy(array $criteria, array $orderBy = null)
 * @method Topics[]    findAll()
 * @method Topics[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TopicsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Topics::class);
    }

    // /**
    //  * @return Topics[] Returns an array of Topics objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Topics
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */


    public function findTopicsByTitre($titre){
        return $this->createQueryBuilder('topics')
            ->where('topics.titre LIKE :titre')
            ->setParameter('titre', '%'.$titre.'%')
            ->getQuery()
            ->getResult();
    }


    public function countByDate(){
        $query = $this->getEntityManager()->createQuery("SELECT SUBSTRING(a.date, 1, 10) as date, COUNT(a) as count FROM App\Entity\Topics a GROUP BY date");
        return $query->getResult();
    }


}
