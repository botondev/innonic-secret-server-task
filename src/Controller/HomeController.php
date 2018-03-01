<?php
/**
 * Created by PhpStorm.
 * User: Bboto
 * Date: 27/02/2018
 * Time: 15:08
 */

namespace App\Controller;


use App\Service\UnitOfWork;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{
    private $unitOfWork;

    function __construct(UnitOfWork $unitOfWork)
    {
        $this->unitOfWork = $unitOfWork; // new UnitOfWork($this->getDoctrine()->getManager());
    }

    /**
     * @Route("/", name="app_homepage")
     */
    public function index()
    {
        $testDebugValue = "test";

        return $this->render('home/index.html.twig',[
            'title' => 'Home Page'
        ]);
    }
}