<?php

namespace App\Controller;

use App\Entity\Session;
use App\Repository\SoutenanceRepository;
use League\Csv\Reader;
use App\Entity\Upload;
use App\Form\SessionType;
use App\Form\UploadType;
use App\Form\FormMailType;
use App\Repository\SessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;



//Mailing
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;



class SessionController extends AbstractController
{
    /**
     * @isGranted("ROLE_USER")
     * @Route("/session", name="session")
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
     * @Route("/session/cosv5/{uid}",name="session_user")
     * @param Session $session
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function show_user(Session $session, EntityManagerInterface $manager)
    {
        dump($this->getUser()->getEmail());
        return $this->render('session/showUser.html.twig',[
            'user'=>$this->getUser(),
            'session'=>$session
        ]
            );
    }
    
    /**
     *
     * @Route("/session/{id}",name="session_show")
     * @param Session $session
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function show(Session $session, EntityManagerInterface $manager, SessionInterface $sessionInterface)
    {
        
        dump($sessionInterface->get("emailbagetudiant"));
        dump($sessionInterface->get("emailbagjury"));
        return $this->render('session/show.html.twig',[
                'user'=>$this->getUser(),
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
     * @param SessionInterface $sessionInterface est un session bag pour gérer l'envoi de mail
     * @return RedirectResponse|Response
     */
    public function edit(Request $request, EntityManagerInterface $manager, SoutenanceRepository $repo, Session $session, SessionInterface $sessionInterface)
    {
        $session->setListeEtudiant("");
        $session->setListeJury("");
        dump($session);
        $soutenances = $repo->findAll();
        $formSession = $this->createForm(SessionType::class, $session, ['soutenances' => $soutenances]);
        $formSession->handleRequest($request);


        // Création du session bag pour l'envoi de mail
        $sessionInterface->set("emailbagetudiant", []);
        $emailbag = $sessionInterface->get("emailbagetudiant", []);

        if ($formSession->isSubmitted() && $formSession->isValid()) {

            $manager->persist($session);
            $manager->flush();
           

            //Objet mail Etudiant
            $objet = $formSession->get("texteMailEtudiant")->getData();
            $objet = explode("{{Debut_objet_courriel}}", $objet)[1];
            $objet = explode("{{Fin_objet_courriel}}", $objet)[0];
            $sessionInterface->set("objetetudiant", $objet);

            //Texte mail etudiant
            $texte_mail_etudiant= $formSession->get("texteMailEtudiant")->getData();
            $texte_mail_etudiant = explode("{{Fin_objet_courriel}}", $formSession->get("texteMailEtudiant")->getData())[1];
            $sessionInterface->set("textemailetudiant", $texte_mail_etudiant);

            //Objet mail Jury 
            $objet = $formSession->get("texteMailJury")->getData();
            $objet = explode("{{Debut_objet_courriel}}", $objet)[1];
            $objet = explode("{{Fin_objet_courriel}}", $objet)[0];
            $sessionInterface->set("objetjury", $objet);

            //Texte mail Jury
            $texte_mail_Jury = $formSession->get("texteMailJury")->getData();
            $texte_mail_Jury = explode("{{Fin_objet_courriel}}", $formSession->get("texteMailJury")->getData())[1];
            $sessionInterface->set("textemailjury", $texte_mail_Jury);

            return $this->redirectToRoute('session_edit_etudiant', ['id' => $session->getId()]);
        }


        return $this->render('session/edit.html.twig', [
            'formSession' => $formSession->createView(),
        ]);
    }

    /**
     * @isGranted("ROLE_ADMIN")
     * @Route("/session/{id}/edit_etudiant", name="session_edit_etudiant")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param Session $session
     * @param SessionInterface $sessionInterface est un session bag pour gérer l'envoi de mail
     * @return RedirectResponse|Response
     */
    public function editEtudiant(Request $request, EntityManagerInterface $manager, SoutenanceRepository $repo, Session $session, SessionInterface $sessionInterface){


        //Upload listeEtudiant
        dump($sessionInterface->get("objetetudiant"));
        dump($sessionInterface->get("textemailetudiant"));
        $sessionInterface->set("emailbagetudiant", []);
        $emailbag = $sessionInterface->get("emailbagetudiant", []);

        $fileEtudiant = new Upload();
        $formUploadListeEtudiant = $this->createForm(UploadType::class, $fileEtudiant);
        $formUploadListeEtudiant->handleRequest($request);
        $row = '';
        if ($formUploadListeEtudiant->isSubmitted() && $formUploadListeEtudiant->isValid()) {
            $fileEtudiant->getName(); // file etudiant à des champs null 
            $sessionInterface->set("fileetudiant", $fileEtudiant->getName());
            $files = $formUploadListeEtudiant->get('name')->getData();
            dump($files);

            $reader = Reader::createFromPath($files->getRealPath())->setHeaderOffset(0);

            $session->setListeEtudiant("Nom, Prénom, Courriel, Groupe : " . "\n");

            foreach ($reader as $row) {
                $session->setListeEtudiant($session->getListeEtudiant() . $row['nom'] . ",");
                $session->setListeEtudiant($session->getListeEtudiant() . $row['prenom'] . ",");
                $session->setListeEtudiant($session->getListeEtudiant() . $row['courriel'] . "," . " Groupe n°");
                $session->setListeEtudiant($session->getListeEtudiant() . $row['groupe'] . "\n");

                array_push($emailbag, $row['courriel']);
            }
            $sessionInterface->set("emailbagetudiant", $emailbag);
            $manager->persist($session);
            $manager->flush();
            return $this->redirectToRoute('session_edit_jury', ['id' => $session->getId()]);
        }
        return $this->render('session/editetudiant.html.twig', [
            'formUploadListeEtudiant' => $formUploadListeEtudiant->createView()
        ]);
    }



    /**
     * @isGranted("ROLE_ADMIN")
     * @Route("/session/{id}/edit_jury", name="session_edit_jury")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param Session $session
     * @param SessionInterface $sessionInterface est un session bag pour gérer l'envoi de mail
     * @return RedirectResponse|Response
     */
    public function editJury(Request $request, EntityManagerInterface $manager, SoutenanceRepository $repo, Session $session, SessionInterface $sessionInterface){

        
        dump($sessionInterface->get("textemailjury"));
        $sessionInterface->set("emailbagjury", []);
        $emailbag = $sessionInterface->get("emailbagjury", []);
            //Upload listeJury
            $fileJury = new Upload();
            $formUploadListeJury = $this->createForm(UploadType::class, $fileJury);
            $formUploadListeJury->handleRequest($request);
            if ($formUploadListeJury->isSubmitted() && $formUploadListeJury->isValid()) {
                $fileJury->getName(); // champs nulls ici aussi 
                $files = $formUploadListeJury->get('name')->getData();
    
                $reader = Reader::createFromPath($files->getRealPath())->setHeaderOffset(0);
    
                $session->setListeJury("Nom, Prénom, Courriel : \n");
                foreach ($reader as $row) {
                    $session->setListeJury($session->getListeJury() . $row['nom'] . ",");
                    $session->setListeJury($session->getListeJury() . $row['prenom'] . ",");
                    $session->setListeJury($session->getListeJury() . $row['courriel'] . "\n");
                    array_push($emailbag,$row['courriel']);
                }
                $sessionInterface->set("emailbagjury", $emailbag);
                $manager->persist($session);
                $manager->flush();
                return $this->redirectToRoute('session_show', ['id' => $session->getId()]);
            }
            return $this->render('session/editjury.html.twig', [
                //'formSession' => $formSession->createView(),
                //'formUploadListeEtudiant' => $formUploadListeEtudiant->createView(),
                'formUploadListeJury' => $formUploadListeJury->createView(),
            ]);
        }

        /**
     * @isGranted("ROLE_ADMIN")
     * @Route("/session/{id}/mail", name="session_mail")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param Session $session
     * @param SessionInterface $sessionInterface est un session bag pour gérer l'envoi de mail
     * @return RedirectResponse|Response
     */
    public function mail(Request $request, EntityManagerInterface $manager, SoutenanceRepository $repo, Session $session, SessionInterface $sessionInterface){

        dump($sessionInterface->get("emailbagetudiant"));
        $form = $this->createForm(FormMailType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){

            //envoi Mail étudiant 
            $emailbagetudiant = $sessionInterface->get("emailbagetudiant");
            $objetetudiant = $sessionInterface->get("objetetudiant");
            $texte_mail_etudiant = $sessionInterface->get("textemailetudiant");

            foreach ($emailbagetudiant as $email){



                //traitement du mail à envoyer pour les étudiants
                $tmp = $email;
                $prenom = explode(".",$tmp)[0];
                $nom = explode(".",explode("@",$tmp)[0])[1];
                $body = $texte_mail_etudiant;
                $body = str_replace("{{Prenom}}", $prenom, $body);
                $body = str_replace("{{Nom}}", $nom, $body);

                $mail = new PHPMailer(true);
                $mail->Encoding = 'base64';
                $mail->CharSet = "UTF-8";

                //Server settings
                $mail->isSMTP();                                            
                $mail->Host       = 'z.mines-telecom.fr';                   
                $mail->SMTPAuth   = true;                                  

                $mail->Username = $form->get('email')->getData();
                $mail->Password = $form->get('password')->getData();


                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;        
                $mail->Port       = 587;


                $mail->setFrom('ne-pas-repondre@COS.com', 'Soutenance COS');
                $mail->addAddress($email);


                $mail->Subject = $objetetudiant;
                $mail->Body = $body;

                $mail->send();
            }

            //Envoi mail Jury

            
            return $this->redirectToRoute('session_show', ['id' => $session->getId()]);
        }
        return $this->render('session/mail.html.twig', [
            'formmail'=>$form->createView()
        ]);
    }
    
    

}
