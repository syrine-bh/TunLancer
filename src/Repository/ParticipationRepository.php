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
    public function findOneByConcour($concour): ?Participation
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.concour = :val')
            ->setParameter('val', $concour)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }
    public function findByConcour($idConcour)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.concour = :val')
            ->setParameter('val', $idConcour)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;
    }
    public function findRanks($id)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT  v.video_id 
  FROM
  votes v
  WHERE v.video_id IN
     ( SELECT video_id FROM participation c WHERE c.concour_id = "'.$id.'"
  ) 
  
 GROUP by v.video_id
 ORDER by count(v.video_id) DESC
 LIMIT 3';
        $stmt = $conn->prepare($sql);

        $stmt->execute();

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAll();


    }
    /**
     * Returns number of "participations" per day
     * @return void
     */
    public function countByDate(){

        $query = $this->getEntityManager()->createQuery("
                SELECT SUBSTRING(a.dateParticipation, 1, 10) as dateParticipation, COUNT(a) as count FROM App\Entity\Participation 
                a GROUP BY dateParticipation
        ");
        return $query->getResult();
    }
}

