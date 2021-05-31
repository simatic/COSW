<?php

namespace App\Controller;

use App\Entity\Session;
use App\Repository\SoutenanceRepository;
use League\Csv\Reader;
use App\Entity\Upload;
use App\Form\SessionType;
use App\Form\UploadType;
use App\Repository\SessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SessionController extends AbstractController
{
    /**
     * @isGranted("ROLE_USER")
     * @Route("/session", name="sessions")
     * @param SessionRepository $repo
     * @return Response
     */
    public function index(SessionRepository $repo): Response
    {
        $sessions = $repo->findAll();
        return $this->render('session/index.html.twig', [
            'controller_name' => 'SessionController',
            'sessions' => $sessions,
        ]);
    }

    /**
     * @isGranted("ROLE_USER")
     * @Route("/session/new", name="session_new")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return RedirectResponse|Response
     */
    public function new(Request $request, EntityManagerInterface $manager){

        $session = new Session();
        $formSession = $this->createForm(SessionType::class, $session);
        $formSession->handleRequest($request);

        if($formSession->isSubmitted() && $formSession->isValid()){

            $manager->persist($session);
            $manager->flush();

            return $this->redirectToRoute('session_show', ['id'=>$session->getId()]);
        }
        return $this->render('session/new.html.twig',[
            'formSession'=> $formSession->createView()
        ]);
    }

    /**
     *
     * @Route("/session/{id}",name="session_show")
     * @param Session $session
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function show(Session $session, EntityManagerInterface $manager)
    {


        return $this->render('session/show.html.twig',[
                'session'=>$session
            ]
        );
    }


    /**
     * @isGranted("ROLE_ADMIN")
     * @Route("/session/{id}/edit", name="session_edit")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param Session $session
     * @return RedirectResponse|Response
     */
    public function edit(Request $request, EntityManagerInterface $manager, SoutenanceRepository $repo, Session $session){

        $soutenances = $repo->findAll();
        $formSession = $this->createForm(SessionType::class, $session, ['soutenances'=>$soutenances]);
        $formSession->handleRequest($request);

        if($formSession->isSubmitted() && $formSession->isValid()){

            $manager->persist($session);
            $manager->flush();
            return $this->redirectToRoute('session_show',['id'=>$session->getId()]);
        }


        //Upload listeEtudiant

        $fileEtudiant = new Upload();
        $formUploadListeEtudiant = $this->createForm(UploadType::class, $fileEtudiant);
        $formUploadListeEtudiant->handleRequest($request);
        $row = '';
        if($formUploadListeEtudiant->isSubmitted() && $formUploadListeEtudiant->isValid()){
            $fileEtudiant->getName();
            $files = $formUploadListeEtudiant->get('name')->getData();
            $reader = Reader::createFromPath($files->getRealPath())->setHeaderOffset(0);

            $session->setListeEtudiant("nom,prenom,courriel,groupe\r\n");
            foreach ($reader as $row) {
                $session->setListeEtudiant($session->getListeEtudiant().$row['nom'].",");
                $session->setListeEtudiant($session->getListeEtudiant().$row['prenom'].",");
                $session->setListeEtudiant($session->getListeEtudiant().$row['courriel'].",");
                $session->setListeEtudiant($session->getListeEtudiant().$row['groupe']."\r\n");
            }
            $manager->persist($session);
            $manager->flush();
            return $this->redirectToRoute('session_show',['id'=>$session->getId()]);
        }

        //Upload listeJury

        $fileJury = new Upload();
        $formUploadListeJury = $this->createForm(UploadType::class, $fileJury);
        $formUploadListeJury->handleRequest($request);
        if($formUploadListeJury->isSubmitted() && $formUploadListeJury->isValid()){
            $fileJury->getName();
            $files = $formUploadListeJury->get('name')->getData();
            $reader = Reader::createFromPath($files->getRealPath())->setHeaderOffset(0);

            $session->setListeJury("nom,prenom,courriel\r\n");
            foreach ($reader as $row) {
                $session->setListeJury($session->getListeJury().$row['nom'].",");
                $session->setListeJury($session->getListeJury().$row['prenom'].",");
                $session->setListeJury($session->getListeJury().$row['courriel']."\r\n");
            }
            $manager->persist($session);
            $manager->flush();
            return $this->redirectToRoute('session_show',['id'=>$session->getId()]);
        }


        return $this->render('session/edit.html.twig',[
            'formSession' => $formSession->createView(),
            'formUploadListeEtudiant' => $formUploadListeEtudiant->createView(),
            'formUploadListeJury' => $formUploadListeJury->createView(),
        ]);
    }


}
