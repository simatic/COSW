<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use App\Entity\FicheEvaluation;
use App\Entity\Item;
use App\Form\FicheEvaluationType;
use App\Form\ItemType;
use App\Form\RubriqueType;
use App\Entity\Rubrique;
use App\Entity\Modele;
use App\Form\ModeleType;
use App\Repository\RubriqueRepository;

class FicheController extends AbstractController
{
    /**
     * @Route("/new_fiche", name="fiche")
     */
    public function form2(Request $request, EntityManagerInterface $manager, Security $security)
    {
        
        $fiche = new FicheEvaluation();
        
        $form_fiche = $this->createForm(FicheEvaluationType::class, $fiche);
        $form_item = $this->createForm(ItemType::class);
        $form_rubrique = $this->createForm(RubriqueType::class);
        
        $form_fiche->handleRequest($request);
        
        if($form_fiche->isSubmitted() && $form_fiche->isValid()){
            $manager->persist($fiche);
            $fiche->setEvaluateur($this->getUser());
            $fiche->setNoteFinal(0);
            $fiche->setPonderation(1);
            $manager->flush();
            
            return $this->render('fiche/NewFiche.html.twig', [
                'form_fiche' => $form_fiche->createView(),
                'form_item' => $form_item->createView(),
                'form_rubrique' => $form_rubrique->createView()
            ]);
            
            //return $this->redirectToRoute('session_show', ['id'=>$session->getId()]);
        }
        
        return $this->render('fiche/NewFiche.html.twig', [
            'form_fiche' => $form_fiche->createView(),
            'form_item' => $form_item->createView(),
            'form_rubrique' => $form_rubrique->createView()
        ]);
    }
    
    /**
     * @Route("/fiche/edit/{id}", name="fiche")
     */
    public function form(Request $request, EntityManagerInterface $manager, Security $security, Rubrique $rub = null, Item $ite = null)
    {
        
        $fiche = new FicheEvaluation();
        $rubrique = new Rubrique();
        $item = new Item();
        
        $form_fiche = $this->createForm(FicheEvaluationType::class, $fiche);
        $form_item = $this->createForm(ItemType::class);
        $form_rubrique = $this->createForm(RubriqueType::class);
        
        $form_fiche->handleRequest($request);
        
        if($form_fiche->isSubmitted() && $form_fiche->isValid()){
            $manager->persist($fiche);
            $fiche->setEvaluateur($this->getUser());
            $fiche->setNoteFinal(0);
            $fiche->setPonderation(1);
            $manager->flush();
            
            return $this->render('fiche/NewRubrique.html.twig', [
                'form_fiche' => $form_fiche->createView(),
                'form_item' => $form_item->createView(),
                'form_rubrique' => $form_rubrique->createView()
            ]);
            
            //return $this->redirectToRoute('session_show', ['id'=>$session->getId()]);
        }
        
        return $this->render('fiche/NewRubrique.html.twig', [
            'fiche' => $fiche->getId() !== null,
            'form_fiche' => $form_fiche->createView(),
            'form_item' => $form_item->createView(),
            'form_rubrique' => $form_rubrique->createView()
        ]);
    }
    
    /**
     * @Route("/modele/new", name="modele_new")
     */
    public function Modele_new(Request $request, EntityManagerInterface $manager, Security $security)
    {
        
        $modele = new Modele();
                
        $form = $this->createForm(ModeleType::class, $modele);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            dump($modele);
            $manager->persist($modele);
            $manager->flush();
            
        }
        return $this->render('fiche/NewModele.html.twig', [
            'form' => $form->createView(),
            'titre' => "Ajout d'un modèle de fiche d'évaluation"
        ]);
    }
    
    /**
     * @Route("/rubrique/new", name="rubrique_new")
     */
    public function rubrique_new(Request $request, EntityManagerInterface $manager, Security $security)
    {
        
        $rubrique = new Rubrique();
        
        $form = $this->createForm(RubriqueType::class, $rubrique);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            dump($rubrique);
            $manager->persist($rubrique);
            $manager->flush();
            
        }
        return $this->render('fiche/NewModele.html.twig', [
            'form' => $form->createView(),
            'titre' => "Ajout d'une rubrique"
        ]);
    }
    
    /**
     * @Route("/item/new", name="item_new")
     */
    public function item_new(Request $request, EntityManagerInterface $manager, Security $security)
    {
        
        $item = new Item();
        
        $form = $this->createForm(ItemType::class, $item);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            dump($item);
            $manager->persist($item);
            $manager->flush();
            
        }
        return $this->render('fiche/NewModele.html.twig', [
            'form' => $form->createView(),
            'titre' => "Ajout d'un item"
        ]);
    }
    
    /**
     * @Route("/rubrique", name="rubrique")
     */
    public function rubrique(RubriqueRepository $repo ,Request $request, EntityManagerInterface $manager, Security $security)
    {
        
        $rubrique = $repo->findAll();
        return $this->render('fiche/home.html.twig', [
            'rubriques'=>$rubrique
        ]
            
        );
    }
}
