<?php
namespace App\Controller;

use App\Entity\Evaluate;
use App\Entity\Evaluation;
use App\Entity\Rubrique;
use App\Form\AddItemType;
use App\Form\EvaluateType;
use App\Form\EvaluationType;
use App\Form\ItemType;
use App\Form\RubriqueType;
use App\Repository\EvaluationRepository;
use App\Repository\FicheEvaluationRepository;
use App\Repository\ItemRepository;
use App\Repository\RubriqueRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Symfony\Component\Routing\Annotation\Route;


class EvaluationController extends AbstractController { //classe définie pour afficher la page Home


    private $evaluationRepository;
    private $ficheEvaluationRepository;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    public function __construct(EvaluationRepository $evaluationRepository, FicheEvaluationRepository $ficheEvaluationRepository, EntityManagerInterface $em, Environment $twig) {
        $this->evaluationRepository = $evaluationRepository;
        $this->ficheEvaluationRepository = $ficheEvaluationRepository;
        $this->em = $em;
    }


    /**
     * @Route (path="/evaluations",name="evaluations")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request) :Response {
        $evaluations = $this->evaluationRepository->findAll();
        return $this->render('pages/evaluation/evaluations.html.twig', [
            'current_page'=>'evaluations',
            'evaluations'=>$evaluations,
        ]);
    }

    /**
     * @Route (path="/evaluation/{id}",name="evaluation")
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function show(Request $request, $id) :Response {
        $evaluation = $this->evaluationRepository->find($id);
        return $this->render('pages/evaluation/evaluation.html.twig', [
            'current_page'=>'rubrique',
            'evaluation'=>$evaluation,
        ]);
    }

    /**
     * @Route (path="/evaluations/new",name="evaluations.new")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request) :Response {
        $evaluation = new Evaluation();
        $fiches = $this->ficheEvaluationRepository->findAll();
        $form = $this->createForm(EvaluationType::class,$evaluation,['fiches'=>$fiches]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($evaluation);
            $this->em->flush();
            return $this->redirectToRoute('evaluations');
        }

        return $this->render('pages/evaluation/new.html.twig', [
            'current_page'=>'evaluations.new',
            'evaluation'=>$evaluation,
            'form'=>$form->createView(),
        ]);
    }

    /**
     * @Route (path="/edit/evaluation/{id}",name="evaluation.edit",methods="GET|POST")
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function edit(Request $request, $id) :Response {
        $evaluation = $this->evaluationRepository->find($id);
        //$fichesListe = $this->ficheEvaluationRepository->findAll();

        $form = $this->createForm(EvaluationType::class,$evaluation);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            return $this->redirectToRoute('evaluations');
        }

        return $this->render('pages/evaluation/edit.html.twig', [
            'current_page'=>'evaluation.edit',
            'evaluation'=>$evaluation,
            'form'=>$form->createView(),
        ]);
    }

    /**
     * @Route (path="evaluate/evaluation/{id}",name="evaluation.evaluate")
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function evaluate(Request $request, $id) :Response {
        $evaluation = $this->evaluationRepository->find($id);
        $evaluate = new Evaluate();
        /*foreach ($evaluation->getFiche()->getRubriques() as $rubrique) {
            if(!$rubrique == null) {
                $evaluate->addRubrique($rubrique);
            }
        }*/

        $form = $this->createForm(EvaluateType::class,$evaluation->getFiche());
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            return $this->redirectToRoute('evaluations');
        }

        return $this->render('pages/evaluation/evaluate.html.twig', [
            'current_page'=>'evaluation.evaluate',
            'evaluation'=>$evaluation,
            'form'=>$form->createView(),
        ]);
    }

    /**
     * @Route (path="/edit/evaluation/{id}",name="evaluation.delete", methods="DELETE")
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function delete(Request $request, $id) :Response {
        $evaluation = $this->evaluationRepository->find($id);
        $this->em->remove($evaluation);
        $this->em->flush();
        return $this->redirectToRoute('evaluations');
    }


}