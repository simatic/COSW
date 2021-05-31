<?php

namespace App\Controller;

use App\Entity\Commentaire;
use League\Csv\Reader;
use League\Csv\Writer;
use App\Entity\Modele;
use App\Entity\Session;
use App\Entity\Item;
use App\Entity\Soutenance;
use App\Form\SessionType;
use App\Repository\SessionRepository;
use App\Repository\SoutenanceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;
use PhpParser\Node\Scalar\MagicConst\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;
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
        return $this->render('home/index.html.twig', [
        ]
            
            );
    }

    /**
     *
     * @isGranted("ROLE_USER")
     * @Route("/session",name="session")
     */
    public function session(SessionRepository $repo)
    {
        $sessions = $repo->findAll();
        return $this->render('soutenance/session.html.twig', [
            'sessions'=>$sessions
        ]);
    }
    
    /**
     * @isGranted("ROLE_ADMIN")
     * @Route("/Soutenance/new", name="soutenance_new")
     * @Route("/Soutenance/{id}/edit", name="soutenance_edit")
     */
    public function form(Request $request, EntityManagerInterface $manager, Soutenance $soutenance = null){

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
    
    /**
     * @isGranted("ROLE_USER")
     * @Route("/Soutenance/{id}/commentaire/new", name="add_commentaire")
     */
    public function form2(Soutenance $soutenance , Request $request, EntityManagerInterface $manager, Security $security){

        $commentaire = new Commentaire();
        $formCommentaire = $this->createFormBuilder($commentaire)
        ->add('Contenu')->add('note')->getForm();
        $commentaire->setSoutenance($soutenance);
        $commentaire->setAuteur($security->getUser()->getUsername());
        $formCommentaire->handleRequest($request);
        
        if($formCommentaire->isSubmitted() && $formCommentaire->isValid()){
            
            $manager->persist($commentaire);
            $manager->flush();
            
            $repo = $manager->getRepository(Commentaire::class)->findBy([
                'soutenance'=>$soutenance
            ]);
            $sum=0;
            foreach ($repo as $comment){
                $sum=$sum+$comment->getNote();
            }
            $soutenance->setNote($sum/count($repo));
            $manager->persist($commentaire);
            $manager->persist($soutenance);
            $manager->flush();
            return $this->redirectToRoute('soutenance_show',['id'=>$soutenance->getId()]);
        }
        return $this->render('soutenance/newComment.html.twig',[
            'formCommentaire'=> $formCommentaire->createView()
        ]);
    }
    
    /**
     * @isGranted("ROLE_USER")
     * @Route("/modele/upload", name="upload_modele")
     */
    public function test( Request $request, EntityManagerInterface $manager){
        
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
                    $rubrique->setCommentaire('');
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
    
    /**
     * @isGranted("ROLE_USER")
     * @Route("/Session/new", name="Session_new")
     */
    public function NewSession(Request $request, EntityManagerInterface $manager){
        
        $session = new Session();
        
        
        $formSession = $this->createForm(SessionType::class,$session);
        $formSession->handleRequest($request);
        
        if($formSession->isSubmitted() && $formSession->isValid()){
            
            $manager->persist($session);
            $manager->flush();
            
            return $this->redirectToRoute('session_show', ['id'=>$session->getId()]);
        }
        return $this->render('soutenance/newSession.html.twig',[
            'formSession'=> $formSession->createView()
        ]);
    }

    /**
     * @isGranted("ROLE_USER")
     * @Route("/export", name="export")
     */
    public function Export1(Request $request, EntityManagerInterface $manager){
    
        return $this->render('soutenance/export.html.twig',[
        ]);
    }
    
    /**
     * @Route("/export_soutenance/{id}", name="export_soutenance")
     */
    public function export(EntityManagerInterface $manager, Session $session){
        $em = $this->getDoctrine()->getManager();
        if(!$session){
            $soutenances = $em->getRepository(Soutenance::class)->findAll();
        }else{
            $soutenances = $em->getRepository(Soutenance::class)->findBy([
                'session'=>$session
            ]);
        }
        $csv = writer::createFromFileObject(new \SplTempFileObject());
        $csv->insertOne(['Soutenance_name']);
        foreach($soutenances as $soutenance){
            $csv->insertOne([$soutenance->getTitre() , date_format($soutenance->getDateSoutenance(), 'Y-m-d H:i:s')]);
        }
        $csv->output("base.csv");
        die('');
        return $this->redirectToRoute('session_show', ['id'=>1]);
        
    }
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
            'soutenance'=> $soutenance,
            'commentaires'=> $repo
        ]
            );
    }
    
    
    /**
     *
     * @Route("/Session/{id}",name="session_show")
     */
    public function show_session(Session $session, EntityManagerInterface $manager)
    {
        $repo = $manager->getRepository(Soutenance::class)->findBy([
            'session'=>$session
        ]);
        
        
        return $this->render('soutenance/Session_show.html.twig',[
            'soutenances'=> $repo,
            'session'=>$session
        ]
            );
    }
    

}
