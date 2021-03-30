<?php

namespace App\Repository;

use App\Entity\Usersignal;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Usersignal|null find($id, $lockMode = null, $lockVersion = null)
 * @method Usersignal|null findOneBy(array $criteria, array $orderBy = null)
 * @method Usersignal[]    findAll()
 * @method Usersignal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsersignalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Usersignal::class);
    }

    // /**
    //  * @return Usersignal[] Returns an array of Usersignal objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Usersignal
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
