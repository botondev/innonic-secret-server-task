<?php

namespace App\Controller;

use App\Entity\Secret;
use App\Helpers\GUID;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SecretController extends Controller
{
    /**
     * @Route("/secret", name="secret")
     */
    public function index()
    {
        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to your action: index(EntityManagerInterface $em)
        $em = $this->getDoctrine()->getManager();

        $now = new \DateTime('now');
        $secret = new Secret();
        $secret->setCreatedAt($now);
        //TODO: time just don't want to change no matter what method I am using. FIX IT
        $nextWeek = $now->modify("+7 day"); //add 7 days
        $secret->setExpiresAt($nextWeek);
        $secret->setHash(GUID::getGUID()); //use a globally unique id for now
        $secret->setRemainingViews(random_int(50,100));
        $secret->setSecretText("Will the next guid be the same as the hash or not ? Guid = " . GUID::getGUID());

        $em->persist($secret);
        $em->flush();

        return new JsonResponse([
            'message' => "Saved new secret with id: ".$secret->getId(),
            'secret' => $secret
        ]);

//        return $this->render('secret/index.html.twig', [
//            'controller_name' => 'SecretController',
//        ]);
    }

}
