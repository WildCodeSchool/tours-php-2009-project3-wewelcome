<?php

namespace App\Repository;

use App\Entity\KeysVision;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method KeysVision|null find($id, $lockMode = null, $lockVersion = null)
 * @method KeysVision|null findOneBy(array $criteria, array $orderBy = null)
 * @method KeysVision[]    findAll()
 * @method KeysVision[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KeysVisionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, KeysVision::class);
    }

    // /**
    //  * @return KeysVision[] Returns an array of KeysVision objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('k')
            ->andWhere('k.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('k.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?KeysVision
    {
        return $this->createQueryBuilder('k')
            ->andWhere('k.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
