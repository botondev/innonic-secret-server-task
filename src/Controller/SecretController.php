<?php

namespace App\Controller;

use App\Entity\Secret;
use App\Helpers\GUID;
use App\Service\UnitOfWork;
use App\Service\SecretPostVM;
use App\Service\SecretVM;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NoResultException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SecretController extends Controller
{
    private $unitOfWork;

    function __construct(UnitOfWork $unitOfWork)
    {
        $this->unitOfWork = $unitOfWork; // new UnitOfWork($this->getDoctrine()->getManager());
    }

    /**
     * @Route("/secret", name="secret", methods={"POST"})
     */
    public function index(Request $request)
    {
        $secretPostVM = new SecretPostVM($request);

        if($secretPostVM->isValid() == false)
        {
            throw new BadRequestHttpException('Post values are not valid');
        }

        // generated code
        // you can fetch the EntityManager via $this->getDoctrine()
        // or you can add an argument to your action: index(EntityManagerInterface $em)
        // $em = $this->getDoctrine()->getManager();

        //$unitOfWork = new UnitOfWork($this->getDoctrine()->getManager());




        //should work here
        $secret = $this->unitOfWork->saveSecretBySecretPostVM($secretPostVM);

        return new JsonResponse([
            'message' => 'secret saved into database',
            'secret' => new SecretVM($secret)
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
        $secret = null;

        try{
            $secret = $this->unitOfWork->getSecretRepository()->findByHash($hash);
        }catch (NoResultException $ex)
        {
            throw $this->createNotFoundException("No Secret was found with hash: $hash");
        }


        //$unitOfWork = new UnitOfWork($this->getDoctrine()->getManager());
        return new JsonResponse([
           'secret' => new SecretVM($secret)
        ]);
    }
}
