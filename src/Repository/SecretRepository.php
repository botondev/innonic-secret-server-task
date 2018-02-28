<?php

namespace App\Repository;

use App\Entity\Secret;
use App\ViewModels\SecretPostVM;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Secret|null find($id, $lockMode = null, $lockVersion = null)
 * @method Secret|null findOneBy(array $criteria, array $orderBy = null)
 * @method Secret[]    findAll()
 * @method Secret[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SecretRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Secret::class);
    }

    public function findByHash(string $hash): Secret
    {
        return $this->createQueryBuilder('s')
            ->where('s.hash = :hash')->setParameter('hash', $hash)
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();
    }

//    public function findNext(int $start, int $count)
//    {
//        return $this->createQueryBuilder('s')
//            ->s
//    }

    /*
    public function findBySomething($value)
    {
        return $this->createQueryBuilder('s')
            ->where('s.something = :value')->setParameter('value', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
}
