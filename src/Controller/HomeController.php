<?php
/**
 * Created by PhpStorm.
 * User: Bboto
 * Date: 27/02/2018
 * Time: 15:08
 */

namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function index()
    {
        $testDebugValue = "test";
        dump($testDebugValue, $this);
        dump($testDebugValue);

        return $this->render('home/index.html.twig',[
            'title' => 'Home Page'
        ]);
    }
}