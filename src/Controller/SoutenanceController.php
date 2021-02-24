<?php

namespace App\Controller;

use App\Entity\Soutenance;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use App\Repository\SoutenanceRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Egulias\EmailValidator\Warning\Comment;
use App\Entity\Commentaire;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Repository\CommentaireRepository;
use Symfony\Component\Security\Core\Security;
use App\Entity\Session;
use App\Form\SessionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Repository\SessionRepository;

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
        ]
            
            );
    }
    
    /**
     * @isGranted("ROLE_ADMIN")
     * @Route("/Soutenance/new", name="soutenance_new")
     * @Route("/Soutenance/{id}/edit", name="soutenance_edit")
     */
    public function form(Soutenance $soutenance = null, Request $request, EntityManagerInterface $manager, Security $security){

        if(!$soutenance){
            $soutenance = new Soutenance();
        }
        $formSoutenance = $this->createFormBuilder($soutenance)
        ->add('titre')->add('session', EntityType::class,['class'=> Session::class,
            'choice_label'=>'nom'
            
        ])->add('description')->add('image')->add('dateSoutenance')->add('note')->getForm();
        
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
    

    /**
     * @isGranted("ROLE_USER")
     * @Route("/Session/new", name="Session_new")
     */
    public function NewSession(Request $request, EntityManagerInterface $manager, Security $security){
        
            $session = new Session();
        
        
        $formSession = $this->createForm(SessionType::class,$session);
        $formSession->handleRequest($request);
        
        if($formSession->isSubmitted() && $formSession->isValid()){
            
            $manager->persist($session);
            $manager->flush();

            return $this->redirectToRoute();
        }
        return $this->render('soutenance/newSession.html.twig',[
            'formSession'=> $formSession->createView()
        ]);
    }
}
