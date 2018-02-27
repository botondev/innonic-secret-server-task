<?php
/**
 * Created by PhpStorm.
 * User: Bboto
 * Date: 27/02/2018
 * Time: 15:08
 */

namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class HomeController
{
    /**
     * @Route()ute("/", name="app_homepage")
     */
    public function index()
    {
        return new Response("Home page");
    }
}