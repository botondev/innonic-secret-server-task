<?php
/**
 * Created by PhpStorm.
 * User: Bboto
 * Date: 28/02/2018
 * Time: 15:31
 */

namespace App\UnitOfWork;


use App\Repository\SecretRepository;
use Doctrine\ORM\EntityManager;
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

    //inject EntityManagerInterface so it can be mocked in unit test
    function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
        $this->secretRepository = new SecretRepository();
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
        $em = $this->getDoctrine()->getManager();
        $secret = new Secret();
        $secret->setCreatedAt(new DateTime('now'));
        $secret->setSecretText($secretPostVM->secret);
        $secret->setRemainingViews($secretPostVM->expireAfterViews);

        if($secretPostVM->expireAfter != 0){
            //increment datetime now with given minutes
            $expires = new \DateTime();
            $interval = new \DateInterval();
            $interval->i = $secretPostVM->expireAfter;
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


}