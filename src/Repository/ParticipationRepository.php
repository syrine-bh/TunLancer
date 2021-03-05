<?php

namespace App\Repository;
use App\Entity\Participation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Participation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Participation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Participation[]    findAll()
 * @method Participation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParticipationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Participation::class);
    }

    public function findUser ($user_id): ?Participation {
        return $this
            ->createQueryBuilder('q')
            ->andWhere('q.id= :val')
            ->setParameter('val',$user_id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function FindByConcId($id)
    {
        return $this->createQueryBuilder('q')
            ->andWhere('q.concour = :val')
            ->setParameter('val', $id)
            ->orderBy('q.id', 'ASC')
            ->setMaxResults(100)
            ->getQuery()
            ->getResult()
            ;
    }
}

