<?php
/**
 * Created by PhpStorm.
 * User: Bboto
 * Date: 28/02/2018
 * Time: 15:31
 */

namespace App\Service;


use App\Entity\Secret;
use App\Repository\SecretRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * A basic unit of work to separate the persistence logic from controllers
 * Class UnitOfWork
 * @package App\UnitOfWork
 */
class UnitOfWork
{
    protected $secretRepository;
    protected $em;

    // it should use IOC container from services.yaml, but I want to try
    // to make it work first and then it can be beautified later when all features works.
    // https://symfony.com/doc/current/service_container.html#services-autowire
    function __construct(EntityManagerInterface $entityManager, SecretRepository $secretRepository)
    {
        $this->em = $entityManager;
        $this->secretRepository = $secretRepository;
    }

    public function getSecretRepository()
    {
        return $this->secretRepository;
    }

    public function getEntityManager()
    {
        return $this->em;
    }

    public function saveSecretBySecretPostVM(SecretPostVM $secretPostVM): Secret
    {
        $secret = new Secret();
        $secret->setCreatedAt(new \DateTime('now'));
        $secret->setSecretText($secretPostVM->secret);
        $secret->setRemainingViews($secretPostVM->expireAfterViews);

        if($secretPostVM->expireAfter != 0){
            //increment datetime now with given minutes
            $expires = new \DateTime('now');
            $interval = new \DateInterval('PT'.$secretPostVM->expireAfter.'M'); //Period (Time) int:minutes Minute
            $expires->add($interval);
            $secret->setExpiresAt($expires);
        }else{
            $secret->setExpiresAt(null); //never expires
        }

        //let the controller handle the error with a 500
        $this->em->persist($secret);
        $this->em->flush();

        return $secret;
    }

    public function updateSecret(Secret $secret): void
    {
        $this->em->persist($secret);
        $this->em->flush();
    }

    public function countDownAndUpdateSecret(Secret $secret): Secret
    {
        if($secret->getRemainingViews() > 0)
        {
            $secret->setRemainingViews(
                $secret->getRemainingViews() - 1
            );

            $this->updateSecret($secret);
        }

        return $secret;
    }


}