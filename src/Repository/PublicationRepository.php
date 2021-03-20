<?php

namespace App\Repository;

use App\Entity\Publication;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Publication|null find($id, $lockMode = null, $lockVersion = null)
 * @method Publication|null findOneBy(array $criteria, array $orderBy = null)
 * @method Publication[]    findAll()
 * @method Publication[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PublicationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Publication::class);
    }

    public function getStoriesDistinct(){
        $query = $this->getEntityManager()
            ->createQuery("SELECT s FROM App\Entity\Publication s WHERE s.type =1 GROUP BY s.idU ");
        return $query->getResult();
    }

    public function getUserStoriesDistinct($idUtilisateur){
        $query = $this->getEntityManager()
            ->createQuery("SELECT s FROM App\Entity\Publication s WHERE s.type =1 AND s.idU='$idUtilisateur' GROUP BY s.idU ");
        return $query->getResult();
    }


    public function getStories(){
        $query = $this->getEntityManager()
            ->createQuery("SELECT s FROM App\Entity\Publication s WHERE s.type =1 ORDER BY s.idU");
        return $query->getResult();
    }

    public function getUserStories($idUtilisateur){
        $query = $this->getEntityManager()
            ->createQuery("SELECT s FROM App\Entity\Publication s WHERE s.type =1 AND s.idU='$idUtilisateur' ORDER BY s.idU");
        return $query->getResult();
    }



    // /**
    //  * @return Publication[] Returns an array of Publication objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Publication
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
