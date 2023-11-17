<?php

namespace App\Repository;

use App\Entity\FeeTier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FeeTier|null find($id, $lockMode = null, $lockVersion = null)
 * @method FeeTier|null findOneBy(array $criteria, array $orderBy = null)
 * @method FeeTier[]    findAll()
 * @method FeeTier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FeeTierRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FeeTier::class);
    }

    // Add custom repository methods here
}