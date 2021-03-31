<?php

namespace App\Repository;

use App\Entity\Users;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Users|null find($id, $lockMode = null, $lockVersion = null)
 * @method Users|null findOneBy(array $criteria, array $orderBy = null)
 * @method Users[]    findAll()
 * @method Users[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Users::class);
    }



    public function UserByPays()
    {
        return $this->createQueryBuilder('u')
            ->select("u.Pays, count(u.Pays)")
            ->groupBy("u.Pays")
            ->getQuery()
            ->getResult()
            ;
    }


    public function UserByAge()
    {
        return $this->createQueryBuilder('u')
            ->select("u.Age, count(u.Age)")
            ->groupBy("u.Age")
            ->getQuery()
            ->getResult()
            ;
    }

    public function UserBySexe()
    {
        return $this->createQueryBuilder('u')
            ->select("u.Sexe, count(u.Sexe)")
            ->groupBy("u.Sexe")
            ->getQuery()
            ->getResult()
            ;
    }

    public function findUserByName($Nom){
        return $this->createQueryBuilder('user')
            ->where('user.Nom LIKE :Nom')
            ->setParameter('Nom', '%'.$Nom.'%')
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Users[] Returns an array of Users objects
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
    public function findOneBySomeField($value): ?Users
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
