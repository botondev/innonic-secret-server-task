<?php

namespace App\Controller;

use App\Entity\Secret;
use App\Helpers\GUID;
use App\Service\UnitOfWork;
use App\Service\SecretPostVM;
use App\Service\SecretVM;
use Doctrine\DBAL\Exception\ServerException;
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
     * @Route("/secret/", name="secret", methods={"POST"})
     */
    public function index(Request $request)
    {
        $secretPostVM = new SecretPostVM($request);

        if($secretPostVM->isValid() == false)
        {
            throw new BadRequestHttpException('Post values are not valid');
        }

        $secret = $this->unitOfWork->saveSecretBySecretPostVM($secretPostVM);

        return new JsonResponse([
            'message' => 'secret saved into database',
            'secret' => new SecretVM($secret)
        ]);
    }

    /**
     * @param string $hash
     * @Route("/secret/{hash}", name="get_secret_by_hash", methods={"GET"})
     * @throws NotFoundHttpException
     * @return JsonResponse
     */
    public function getAvailableByHash(string $hash) : JsonResponse
    {
        $secret = null;

        try
        {
            $secret = $this->unitOfWork->getSecretRepository()->findAvailableByHash($hash);
            $secret = $this->unitOfWork->countDownAndUpdateSecret($secret);
        }catch (NoResultException $ex)
        {
            throw $this->createNotFoundException("No Secret was found with hash: $hash");
        }

        return new JsonResponse([
           'secret' => new SecretVM($secret)
        ]);
    }

    /**
     * This is for demoing the app easier. Originally this would be no part of the released app.
     * @Route("/secret_hashes", name="secret_hash_list", methods={"GET"})
     * @return JsonResponse
     */
    public function getAllAvailableHash() : JsonResponse
    {
        $hashes = $this->unitOfWork->getSecretRepository()->findAllAvailableHashes();

        return new JsonResponse($hashes);
    }
}
