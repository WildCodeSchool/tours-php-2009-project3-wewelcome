<?php

namespace App\Repository;

use App\Entity\Concierge;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Concierge|null find($id, $lockMode = null, $lockVersion = null)
 * @method Concierge|null findOneBy(array $criteria, array $orderBy = null)
 * @method Concierge[]    findAll()
 * @method Concierge[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConciergeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Concierge::class);
    }
}
