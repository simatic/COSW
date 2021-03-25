<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController { //classe définie pour afficher la page Home

    /**
     * @var Twig\Environment
     */
    private $twig;

    public function __construct(Environment $twig) {
        $this->twig = $twig;
    }


    /**
     * @Route (path="/",name="home")
     * @return Response
     */
    public function index() :Response { // méthode appelée pour afficher la page Home

        return $this->render('pages/home.html.twig',['current_page'=>'home']);
    }
}