<?php

namespace App\Controller;

use App\Entity\Secret;
use App\Helpers\GUID;
use App\UnitOfWork\UnitOfWork;
use App\ViewModels\SecretPostVM;
use App\ViewModels\SecretVM;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SecretController extends Controller
{
    private $em;
    private $unitOfWork;

    function __construct(EntityManagerInterface $em)
    {
        parent::__construct();

        $this->em = $em;
        $this->unitOfWork = new UnitOfWork($em);
    }

    /**
     * @Route("/secret", name="secret", methods={"POST"})
     */
    public function index(SecretPostVM $secretPostVM)
    {
        // generated code
        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to your action: index(EntityManagerInterface $em)
        // $em = $this->getDoctrine()->getManager();

        $secret = $this->unitOfWork->saveSecretBySecretPostVM($secretPostVM);

        return new JsonResponse([
            'message' => "Saved new secret with id: ".$secret->getId(),
            'secret' => $secret
        ]);

//        return $this->render('secret/index.html.twig', [
//            'controller_name' => 'SecretController',
//        ]);
    }

    /**
     * @param string $hash
     * @Route("/secret/{hash}", name="get_secret_by_hash")
     * @return JsonResponse
     */
    public function getByHash(string $hash) : JsonResponse
    {
        return new JsonResponse([
           'secret' => new SecretVM($this->unitOfWork->getSecretRepository()->findByHash($hash))
        ]);
    }
}
