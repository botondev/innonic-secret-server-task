<?php

namespace App\Repository;

use App\Entity\Secret;
use App\Service\SecretPostVM;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NoResultException;
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
        $result = $this->createQueryBuilder('s')
        ->where('s.hash = :hash')->setParameter('hash', $hash)
        ->setMaxResults(1)
        ->getQuery()
        ->getSingleResult();

        return $result;
    }

    public function findAvailableByHash(string $hash): Secret
    {
        $result = $this->createQueryBuilder('s')
            ->where('s.hash = :hash')->setParameter('hash', $hash)
            ->andWhere('s.remainingViews > 0')
            //->andWhere('s.expiresAt >= :now')->setParameter('now', new \DateTime('now'))
            ->setMaxResults(1)
            ->getQuery()
            ->getSingleResult();

        if($result){
            if($result->getExpiresAt() < new \DateTime('now')){
                //$result = null;
                throw new NoResultException();
            }
        }

        return $result;
    }

    public function findAllAvailableHashes()
    {
        $fields = ['s.hash', 's.remainingViews', 's.expiresAt'];

        $result = $this->createQueryBuilder('s')
            ->where('s.remainingViews > 0')
            ->andWhere('s.expiresAt is not null')
            ->andWhere('s.expiresAt >= s.createdAt')
            ->select($fields)
            ->getQuery()
            ->getResult();
            //->execute();

//        var_dump($result);
//        die();


        //quick hack for lacking date support in doctrine
        $finalResult = [];
        for($i = 0; $i < count($result); $i++)
        {
            //$result[$i]->getExpiresAt()
            if($result[$i]['expiresAt'] >= new \DateTime('now')){
                array_push($finalResult, $result[$i]);
            }
        }

        return $finalResult;
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
