<?php
namespace App\Controller;

use App\Form\ItemType;
use App\Repository\ItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Symfony\Component\Routing\Annotation\Route;


class ItemController extends AbstractController {


    private $itemRepository;
    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(ItemRepository $itemRepository, Environment $twig, EntityManagerInterface $em) {
        $this->itemRepository = $itemRepository;
        $this->em =$em;
    }


    /**
     * @Route (path="/items",name="items")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request) :Response {


        $items = $this->itemRepository->findAll();
        return $this->render('pages/item/items.html.twig', [
            'current_page'=>'items',
            'items'=>$items,
        ]);
    }

    /**
     * @Route (path="/item/{id}",name="item")
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function show(Request $request, $id) :Response {


        $item = $this->itemRepository->find($id);
        return $this->render('pages/item/item.html.twig', [
            'current_page'=>'item',
            'item'=>$item,
        ]);
    }

    /**
     * @Route (path="/edit/item/{id}",name="item.edit")
     * @param Request $request
     * @param $id
     * @return Response
     */
    public function edit(Request $request, $id) :Response {
        $item = $this->itemRepository->find($id);
        $form = $this->createForm(ItemType::class,$item);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            return $this->redirectToRoute('items');
        }


        return $this->render('pages/item/edit.html.twig', [
            'current_page'=>'item.edit',
            'item'=>$item,
            'form'=>$form->createView(),
        ]);
    }

}