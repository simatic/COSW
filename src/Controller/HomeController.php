<?php
namespace App\Controller;

use App\Entity\Rubrique;
use App\Form\RubriqueType;
use App\Repository\RubriqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController { //classe définie pour afficher la page Home

    /**
     * @var Twig\Environment
     */
    private $twig;

    private $rubriqueRepository;

    public function __construct(RubriqueRepository $rubriqueRepository, Environment $twig) {
        $this->rubriqueRepository = $rubriqueRepository;
        $this->twig = $twig;
    }


    /**
     * @Route (path="/",name="home")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request) :Response { // méthode appelée pour afficher la page Home
        $form = $this->createForm(RubriqueType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success','Rubrique ajoutée');
        }

        $rubriques = $this->rubriqueRepository->findAll();
        return $this->render('pages/home.html.twig', [
            'current_page'=>'home',
            'rubriques'=>$rubriques,
            'form'=>$form->createView()]);
    }
}