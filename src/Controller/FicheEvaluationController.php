<?php
namespace App\Controller;

use App\Entity\FicheEvaluation;
use App\Form\AddRubriqueType;
use App\Form\FicheEvaluationType;
use App\Repository\FicheEvaluationRepository;
use App\Repository\RubriqueRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Symfony\Component\Routing\Annotation\Route;


class FicheEvaluationController extends AbstractController { //classe définie pour afficher la page Home

    private $ficheEvaluationRepository;
    private $rubriqueRepository;
    /**
     * @var EntityManagerInterface
     */
    private $em;


    public function __construct(RubriqueRepository $rubriqueRepository, FicheEvaluationRepository $ficheEvaluationRepository, EntityManagerInterface $em, Environment $twig) {
        $this->ficheEvaluationRepository = $ficheEvaluationRepository;
        $this->rubriqueRepository = $rubriqueRepository;
        $this->em = $em;
    }

    /**
     * @Route (path="/fiches",name="fiches")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request) :Response {
        $fiches = $this->ficheEvaluationRepository->findAll();
        return $this->render('pages/fiche/fiches.html.twig', [
            'current_page'=>'fiches',
            'fiches'=>$fiches,
        ]);
    }

    /**
     * @Route (path="/fiche/{id}",name="fiche")
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function show(Request $request, $id) :Response {


        $fiche = $this->ficheEvaluationRepository->find($id);
        $rubriques = $fiche->getRubriques();
        return $this->render('pages/fiche/fiche.html.twig', [
            'current_page'=>'fiche',
            'fiche'=>$fiche,
            'rubriques'=>$rubriques,
        ]);
    }

    /**
     * @Route (path="/fiches/new",name="fiches.new")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request) :Response {
        $fiche = new FicheEvaluation();
        $form = $this->createForm(FicheEvaluationType::class,$fiche);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($fiche);
            $this->em->flush();
            return $this->redirectToRoute('fiches');
        }

        return $this->render('pages/fiche/new.html.twig', [
            'current_page'=>'fiches.new',
            'fiche'=>$fiche,
            'form'=>$form->createView(),
        ]);
    }

    /**
     * @Route (path="/edit/fiche/{id}",name="fiche.edit",methods="GET|POST")
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function edit(Request $request, $id) :Response {
        $fiche = $this->ficheEvaluationRepository->find($id);
        $rubriquesListe = $this->rubriqueRepository->findAll();
        $rubriques = $fiche->getRubriques();
        $form = $this->createForm(FicheEvaluationType::class,$fiche);
        $formRubrique = $this->createForm(AddRubriqueType::class, null, ['rubriques'=>$rubriquesListe]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            return $this->redirectToRoute('fiches');
        }

        $formRubrique->handleRequest($request);
        if ($formRubrique->isSubmitted() && $formRubrique->isValid()) {
            $data = $formRubrique->getData();
            $rubrique = $this->rubriqueRepository->findOneBy(['id'=>$data['Rubrique']]);
            $fiche->addRubrique($rubrique);
            $this->em->flush();
            $this->addFlash('success','Rubrique ajouté à la fiche');
        }

        return $this->render('pages/fiche/edit.html.twig', [
            'current_page'=>'fiche.edit',
            'fiche'=>$fiche,
            'rubriques'=>$rubriques,
            'form'=>$form->createView(),
            'formRubrique'=>$formRubrique->createView(),
        ]);
    }

    /**
     * @Route (path="/edit/fiche/{id}",name="fiche.delete", methods="DELETE")
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function delete(Request $request, $id) :Response {
        $fiche = $this->ficheEvaluationRepository->find($id);
        $this->em->remove($fiche);
        $this->em->flush();
        return $this->redirectToRoute('fiches');
    }


}