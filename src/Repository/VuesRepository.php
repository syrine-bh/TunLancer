<?php

namespace App\Repository;

use App\Entity\Vues;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Vues|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vues|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vues[]    findAll()
 * @method Vues[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VuesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vues::class);
    }



    public function getOperateurs(){
        $query = $this->getEntityManager()
            ->createQuery("SELECT COUNT(v.operateur) as nbr,v.operateur FROM App\Entity\Vues v GROUP BY v.operateur");
        return $query->getResult();
    }

    public function GetPays()
    {
        $query = $this->getEntityManager()
            ->createQuery("SELECT COUNT(v.pays) as nbr,v.pays,v.paysCode FROM App\Entity\Vues v GROUP BY v.pays");
        return $query->getResult();
    }

    public function GetRegions()
    {
        $query = $this->getEntityManager()
            ->createQuery("SELECT COUNT(v.region) as nbr,v.region FROM App\Entity\Vues v GROUP BY v.region");
        return $query->getResult();
    }

    public function getVues()
    {
        $query = $this->getEntityManager()
            ->createQuery("SELECT v FROM App\Entity\Vues v GROUP BY v.Utilisateur ");
        return $query->getResult();
    }
    // /**
    //  * @return Vues[] Returns an array of Vues objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Vues
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
