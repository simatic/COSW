<?php
namespace App\Controller;

use App\Entity\Rubrique;
use App\Form\AddItemType;
use App\Form\ItemType;
use App\Form\RubriqueType;
use App\Repository\ItemRepository;
use App\Repository\RubriqueRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Symfony\Component\Routing\Annotation\Route;


class RubriqueController extends AbstractController { //classe définie pour afficher la page Home


    private $rubriqueRepository;
    private $itemRepository;
    /**
     * @var EntityManagerInterface
     */
    private $em;


    public function __construct(RubriqueRepository $rubriqueRepository,ItemRepository $itemRepository, EntityManagerInterface $em, Environment $twig) {
        $this->rubriqueRepository = $rubriqueRepository;
        $this->itemRepository = $itemRepository;
        $this->em = $em;
    }


    /**
     * @Route (path="/rubriques",name="rubriques")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request) :Response {
        $rubriques = $this->rubriqueRepository->findAll();
        return $this->render('pages/rubrique/rubriques.html.twig', [
            'current_page'=>'rubriques',
            'rubriques'=>$rubriques,
            ]);
    }

    /**
     * @Route (path="/rubrique/{id}",name="rubrique")
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function show(Request $request, $id) :Response {


        $rubrique = $this->rubriqueRepository->find($id);
        $items = $rubrique->getItems();
        return $this->render('pages/rubrique/rubrique.html.twig', [
            'current_page'=>'rubrique',
            'rubrique'=>$rubrique,
            'items'=>$items,
        ]);
    }

    /**
     * @Route (path="/rubriques/new",name="rubriques.new")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request) :Response {
        $rubrique = new Rubrique();
        $form = $this->createForm(RubriqueType::class,$rubrique);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($rubrique);
            $this->em->flush();
            return $this->redirectToRoute('rubriques');
        }

        return $this->render('pages/rubrique/new.html.twig', [
            'current_page'=>'rubriques.new',
            'rubrique'=>$rubrique,
            'form'=>$form->createView(),
        ]);
    }

    /**
     * @Route (path="/edit/rubrique/{id}",name="rubrique.edit",methods="GET|POST")
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function edit(Request $request, $id) :Response {
        $rubrique = $this->rubriqueRepository->find($id);
        $itemsListe = $this->itemRepository->findAll();
        $items = $rubrique->getItems();
        $form = $this->createForm(RubriqueType::class,$rubrique);
        $formItem = $this->createForm(AddItemType::class, null, ['items'=>$itemsListe]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            return $this->redirectToRoute('rubriques');
        }

        $formItem->handleRequest($request);
        if ($formItem->isSubmitted() && $formItem->isValid()) {
            //ajouter l'item sélectionné avec $rubrique->addItem()
            $data = $formItem->getData();
            $item = $this->itemRepository->findOneBy(['id'=>$data['Item']]);
            $rubrique->addItem($item);
            $this->em->flush();
            $this->addFlash('success','Item ajouté à la rubrique');
        }

        return $this->render('pages/rubrique/edit.html.twig', [
            'current_page'=>'rubrique.edit',
            'rubrique'=>$rubrique,
            'items'=>$items,
            'form'=>$form->createView(),
            'formItem'=>$formItem->createView(),
        ]);
    }

    /**
     * @Route (path="/edit/rubrique/{id}",name="rubrique.delete", methods="DELETE")
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function delete(Request $request, $id) :Response {
        $rubrique = $this->rubriqueRepository->find($id);
        $this->em->remove($rubrique);
        $this->em->flush();
        return $this->redirectToRoute('rubriques');
    }


}