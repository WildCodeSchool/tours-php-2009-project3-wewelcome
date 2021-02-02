<?php

namespace App\Repository;

use App\Entity\LegalsTexts;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LegalsTexts|null find($id, $lockMode = null, $lockVersion = null)
 * @method LegalsTexts|null findOneBy(array $criteria, array $orderBy = null)
 * @method LegalsTexts[]    findAll()
 * @method LegalsTexts[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LegalsTextsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LegalsTexts::class);
    }

    // /**
    //  * @return LegalsTexts[] Returns an array of LegalsTexts objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?LegalsTexts
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
