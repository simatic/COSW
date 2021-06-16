<?php

namespace App\Controller;

use App\Entity\Commentaire;
use League\Csv\Reader;
use App\Entity\Evaluation;
use App\Entity\Item;
use App\Entity\Modele;
use App\Entity\Session;
use App\Entity\User;
use App\Entity\Soutenance;
use League\Csv\Writer;
use App\Form\ItemType;
use App\Form\ModeleType;
use App\Form\RubriqueType;
use App\Repository\RubriqueRepository;
use App\Repository\SoutenanceRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Upload;
use App\Form\UploadType;
use App\Entity\Rubrique;

class SoutenanceController extends AbstractController
{
    /**
     * @isGranted("ROLE_USER")
     * @Route("/Soutenance", name="soutenance")
     */
    public function index(): Response
    {
        return $this->render('soutenance/index.html.twig', [
            'controller_name' => 'CommentaireController',
        ]);
    }
    
    /**
     * 
     * @isGranted("ROLE_USER")
     * @Route("/",name="home")
     */
    public function home(SoutenanceRepository $repo)
    {
        $soutenance = $repo->findAll();
        return $this->render('soutenance/home.html.twig', [
            'soutenances'=>$soutenance
        ]
            
            );
    }

    /* Cette "fonction" possède 2 routes qui permette de soit créer une soutenance ou bien de la modifier*/
    /**
     * 
     * @Route("/Soutenance/new", name="soutenance_new")
     * @Route("/Soutenance/{id}/edit", name="soutenance_edit")
     */
    public function SoutenanceAdd(Request $request, EntityManagerInterface $manager, Soutenance $soutenance = null){
        
        if(!$soutenance){
            $soutenance = new Soutenance();
            $soutenance->setNote(0);
        }
        $formSoutenance = $this->createFormBuilder($soutenance)
        ->add('titre')->add('session', EntityType::class,['class'=> Session::class,
            'choice_label'=>'nom'
        ])->add('description')->add('image')->add('dateSoutenance')
        ->add('modele', EntityType::class,['class'=> Modele::class,
            'choice_label'=>'Modele'
        ])->getForm();
        
        $formSoutenance->handleRequest($request);
        
        if($formSoutenance->isSubmitted() && $formSoutenance->isValid()){
            
            $manager->persist($soutenance);
            $manager->flush();
            
            return $this->redirectToRoute('soutenance_show',['id'=>$soutenance->getId()]);
        }
        return $this->render('soutenance/new.html.twig',[
            'formSoutenance'=> $formSoutenance->createView(),
            'editMode' => $soutenance->getId() !== null
        ]);
    }
    
    
    /* Cette route permet à un pair d'ajouter un commentaire*/
    /**
     * @isGranted("ROLE_USER")
     * @Route("/session/cosv5/{uid}/{uidSession}/soutenance/{id}/commenter", name="add_commentaire")
     */
    public function Commentaire(String $uid,String $id,String $uidSession, EntityManagerInterface $manager,Request $request){
        $soutenance = $manager->getRepository(Soutenance::class)->findOneBy(['id'=>$id]);
        if(is_null($soutenance)){
            dump("Erreur Soutenance");
        }
        $session = $manager->getRepository(Session::class)->findOneBy(['uid'=>$uidSession]);
        if(is_null($session)){
            dump("Erreur Session");
        }
        $user = $manager->getRepository(User::class)->findOneBy(['uid'=>$uid]);
        if(is_null($user)){
            dump("Erreur Utilisateur");
        }
        $commentaire = $manager->getRepository(Commentaire::class)->findOneBy(['auteur'=>$this->getUser()->getEmail(),
            'soutenance'=>$soutenance]);
        if(!$commentaire){
            $commentaire = new Commentaire();
        }
        dump($commentaire);
        $formCommentaire = $this->createFormBuilder($commentaire)
        ->add('Contenu')->getForm();
        $commentaire->setSoutenance($soutenance);
        $commentaire->setAuteur($this->getUser()->getEmail());
        $formCommentaire->handleRequest($request);
        
        if($formCommentaire->isSubmitted() && $formCommentaire->isValid()){
            
            $manager->persist($commentaire);
            $manager->flush();
            
            return $this->redirectToRoute('session_user',['uid'=>$soutenance->getSession()->getUid()]);
        }
        return $this->render('soutenance/newComment.html.twig',[
            'formCommentaire'=> $formCommentaire->createView()
        ]);
    }
    
    /*Cette route permet aux créateurs d'uploader des modèles de fiches d'évaluation à partir d'un fichier CSV*/
    /**
     * @Route("/modele/upload", name="upload_modele")
     */
    public function uploadModele( Request $request, EntityManagerInterface $manager, UserRepository $userRepository){
        $file = new Upload();
        $form = $this->createForm(UploadType::class, $file);
        $form->handleRequest($request);
        $row = '';
        if($form->isSubmitted() && $form->isValid()){
            $file->getName();
            //$fileName = md5(uniqid()).'.'.$file->guessExtension();
            $files = $form->get('name')->getData();
            $reader = Reader::createFromPath($files->getRealPath())->setHeaderOffset(0);
            $rubrique = new Rubrique();
            $modele = new Modele();
            foreach ($reader as $row) {
                if($row['modele_name'] != $modele->getName()){
                    $modele = new Modele();
                    $modele->setName($row['modele_name']);
                }
                if($row['rubrique_name'] != $rubrique->getNom()){
                    $rubrique = new Rubrique();
                    $rubrique->setNom($row['rubrique_name']);
                    $modele->addRubrique($rubrique);
                    $item = (new Item())->setNom($row['item_name']);
                    $item->setNote($row['item_note']);
                    $modele->addItem($item);
                    $rubrique->addItem($item);
                }
                else{
                    $item = (new Item())->setNom($row['item_name']);
                    $item->setNote($row['item_note']);
                    $modele->addItem($item);
                    $rubrique->addItem($item);
                }
                $manager->persist($item);
                $manager->persist($rubrique);
                $manager->persist($modele);
                $manager->flush();
                dump($modele);
            }
            
            //return $this->redirectToRoute('soutenance');
        }
        return $this->render('fiche/UploadModele.html.twig',[
            'form_fiche'=> $form->createView()
        ]);
    }

    /*Affichage pour plus de détails d'une soutenance*/
    /**
     *
     * @Route("/Soutenance/{id}",name="soutenance_show")
     */
    public function show_soutenance(Soutenance $soutenance, EntityManagerInterface $manager)
    {
        $repo = $manager->getRepository(Commentaire::class)->findBy([
            'soutenance'=>$soutenance
        ]);
        
        return $this->render('soutenance/show.html.twig',[
            'user'=>$this->getUser(),
            'soutenance'=> $soutenance,
            'commentaires'=> $repo
        ]
            );
    }
    
    
    /* Cette route est dédié aux pairs, elle permet à chaque pair d'évaluer une soutenance */
    /**
     *
     * @Route("/session/cosv5/{uid}/{uidSession}/soutenance/{id}/evaluer" ,name="evaluer_soutenance")
     */
    public function evaluation_soutenance(String $uid,String $id,String $uidSession, EntityManagerInterface $manager,Request $request)
    {
        $soutenance = $manager->getRepository(Soutenance::class)->findOneBy(['id'=>$id]);
        if(is_null($soutenance)){
            dump("Erreur Soutenance");
        }
        //on vérifie bien que les champs dans le url du pair pointent bien sur des données de la base de données
        //Si cela ne correspond pas à une entité de la base de données dans ce cas on pourra les rediriger vers une page d'erreur
        //mais ici on affiche juste un message
        $session = $manager->getRepository(Session::class)->findOneBy(['uid'=>$uidSession]);
        if(is_null($session)){
            dump("Erreur Session");
        }
        $user = $manager->getRepository(User::class)->findOneBy(['uid'=>$uid]);
        if(is_null($user)){
            dump("Erreur Utilisateur");
        }
        $evaluations = $manager->getRepository(Evaluation::class)->findBy([
            'Soutenance'=>$soutenance,
            'User'=>$this->getUser()
        ]);
        
        $edit = !empty($evaluations);
        $modele =  $soutenance->getModele();
        
        $items = $modele->getItems();
        $rubriques = $modele->getRubriques();
        $form = $this->createFormBuilder();
        foreach($items as $item){
            if($edit){
                $evaluation = $manager->getRepository(Evaluation::class)->findOneBy([
                    'Soutenance'=>$soutenance,
                    'User'=>$this->getUser(),
                    'item'=>$item
                ]);
                $form = $form->add($item->getId(), IntegerType::class,[
                    'attr'=>[
                        'label'=>$item->getNom(),
                        'value'=>($evaluation->getNote()/20)*100/($item->getNote()/100)
                    ]
                ]);
            }else{
                $form = $form->add($item->getId(), IntegerType::class,[
                    'attr'=>[
                        'label'=>$item->getNom()
                    ]
                    
                ]);
            }
        }
        if($edit){
            $form = $form->add('Modifier', SubmitType::class)
            ->getForm();
        }else{
            $form = $form->add('Evaluer', SubmitType::class)
            ->getForm();
        }
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            // data is an array with "name", "email", and "message" keys
            $data = $form->getData();
            $i = 0;
            if(!$edit){
                foreach($data as $itemId => $note){
                    $evaluation = new Evaluation();
                    $item=  $manager->getRepository(Item::class)->findOneBy([
                        'id'=>$itemId
                    ]);
                    $evaluation->setItem($item);
                    $evaluation->setUser($this->getUser());
                    $evaluation->setSoutenance($soutenance);
                    $evaluation->setNote($note);
                    $i++;
                    $manager->persist($evaluation);
                }
            }else{
                foreach($data as $itemId => $note){
                    $evaluation = $manager->getRepository(Evaluation::class)->findOneBy([
                        'Soutenance'=>$soutenance,
                        'User'=>$this->getUser(),
                        'item'=>$itemId
                    ]);
                    $item = $manager->getRepository(Item::class)->findOneBy([
                        'id'=>$itemId
                    ]);
                    $evaluation->setNote($note);
                    $i++;
                    $manager->persist($evaluation);
                }
            }
            $manager->flush();
            return $this->redirectToRoute('session_user',['uid'=>$soutenance->getSession()->getUid()]);
        }
        
        return $this->render('soutenance/evaluation.html.twig',[
            'form'=> $form->createView(),
            'items'=>$items,
            'rubriques'=>$rubriques,
            'soutenance'=>$soutenance,
            'editMode' => !empty($manager->getRepository(Evaluation::class)->findBy([
                'Soutenance'=>$soutenance,
                'User'=>$this->getUser()
            ]))
        ]
            );
    }

    /* Cette route permet d'importer toutes les données liés à une session depuis la base de données
     * et de télécharger toutes ces données sous format CSV */
    /**
     * @Route("/export_session?={id}", name="export_session")
     */
    public function export(EntityManagerInterface $manager, Session $session){
        $soutenances = $manager->getRepository(Soutenance::class)->findBy([
            'session'=>$session
        ]);
        $csv = writer::createFromFileObject(new \SplTempFileObject());
        $csv->insertOne(['titre_soutenance','utilisateur','nom_item','note']);
        foreach($soutenances as $soutenance){
            $evaluations = $manager->getRepository(Evaluation::class)->findBy([
                'Soutenance'=>$soutenance
            ]);
            foreach($evaluations as $evaluation){
                $csv->insertOne([$soutenance->getTitre(),$evaluation->getUser()->getFirstName() .' '. $evaluation->getUser()->getLastName() , $evaluation->getItem()->getNom(), $evaluation->getNote()]);
                
            }
        }
        
        $csv->output($session->getNom().'.csv');
        die('');
        return $this->redirectToRoute('session_show', ['id'=>1]);
        
    }
    
    
    /* Création d'un nouveau modèle de fiche d'évaluation qui est composé de plusieurs items et rubriques*/
    /**
     * @Route("/modele/new", name="modele_new")
     */
    public function Modele_new(Request $request, EntityManagerInterface $manager)
    {
        
        $modele = new Modele();
        
        $form = $this->createForm(ModeleType::class, $modele);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $rubriques = $form->getData()->getRubriques();
            //dump($rubriques);
            foreach($rubriques as $rubrique){
                $items = $rubrique->getItems();
                $modele->addRubrique($rubrique);
                foreach($items as $item){
                    $modele->addItem($item);
                }
            }
            //dump($modele);
            $manager->persist($modele);
            $manager->flush();
            return $this->render('fiche/NewModele.html.twig', [
                'form' => $form->createView(),
                'titre' => "Ajout d'un modèle de fiche d'évaluation"
            ]);
        }
        return $this->render('fiche/NewModele.html.twig', [
            'form' => $form->createView(),
            'titre' => "Ajout d'un modèle de fiche d'évaluation"
        ]);
    }
    
    /*Création d'une nouvelle rubrique*/
    /**
     * @Route("/rubrique/new", name="rubrique_new")
     */
    public function rubrique_new(Request $request, EntityManagerInterface $manager, Security $security)
    {
        
        $rubrique = new Rubrique();
        
        /*On a la possibilité de mettre un commentaire lié à chaque rubrique*/
        
        $form = $this->createForm(RubriqueType::class, $rubrique);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $items = $rubrique->getItems();
            
            $note = 0;
            foreach($items as $item){
                $note = $note + $item->getNote();
            }
            if($note != 20){
                return $this->render('fiche/NewRubrique.html.twig', [
                    'form' => $form->createView(),
                    'titre' => "Erreur"
                ]);
            }
            dump($rubrique);
            $manager->persist($rubrique);
            $manager->flush();
            return $this->render('fiche/NewRubrique.html.twig', [
                'form' => $form->createView(),
                'titre' => "Ajout d'une rubrique"
            ]);
            
        }
        return $this->render('fiche/NewRubrique.html.twig', [
            'form' => $form->createView(),
            'titre' => "Ajout d'une rubrique"
        ]);
    }
    
    /* Ajouter un item */
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
    
    /* Checker toutes les rubriques */
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
