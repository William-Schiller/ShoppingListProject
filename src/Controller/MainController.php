<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MainController
 * @package App\Controller
 * @Route(path="", name="main_")
 */
class MainController extends AbstractController
{
    /**
     * @Route("", name="home")
     */
    public function home(): Response
    {
        return $this->render('main/index.html.twig');
    }

    /**
     * @Route("test", name="test")
     */
    public function test(): Response
    {
        return $this->render('main/test.html.twig');
    }
}
