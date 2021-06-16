<?php

namespace App\Controller;

use App\Entity\Session;
use App\Repository\SoutenanceRepository;
use League\Csv\Reader;
use App\Entity\Upload;
use App\Form\SessionType;
use App\Form\UploadType;
use App\Entity\Peer;
use App\Entity\User;
use App\Form\FormMailType;
use App\Repository\SessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Routing\Annotation\Route;
use League\Csv\Writer;
//Mailing
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class SessionController extends AbstractController
{
    /*Cette route est la route permettant de voir toutes les sessions sous la forme d'un tableau,
     * à partir de cette route vous pouvez ajouter une session ou bien la modifier etc... */
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

    /* Création d'une nouvelle session */
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
            $session->setListeEtudiant("");
            $session->setListeJury("");
            $session->setUid(sha1(random_bytes(10)));
            $manager->persist($session);
            $manager->flush();

            return $this->redirectToRoute('session_show', ['id'=>$session->getId()]);
        }
        return $this->render('session/new.html.twig',[
            'formSession'=> $formSession->createView()
        ]);
    }
    
    /* lorsque le pair va cliquer sur le lien ça va le rediriger vers ce lien où il pourra
     * voir toutes les soutenances pour les évaluer etc.. */
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
    
    /* Ce chemin est plutot dédié aux admins pour vérifier les sessions */
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
        //dump($sessionInterface->get("emailbagjury"));
        return $this->render('session/show.html.twig',[
                'user'=>$this->getUser(),
                'session'=>$session
            ]
        );
    }


    /* Edifier une session ou bien ajouter la liste des jurys/ étudiants */
    /**
     * @isGranted("ROLE_CREATOR", "ROLE_ADMIN")
     * @Route("/session/{id}/edit", name="session_edit")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param Session $session
     * @param SessionInterface $sessionInterface est un session bag pour gérer l'envoi de mail
     * @return RedirectResponse|Response
     */
    public function edit(Request $request, EntityManagerInterface $manager, SoutenanceRepository $repo, Session $session, SessionInterface $sessionInterface)
    {

        //dump($sessionInterface->get("emailbagetudiant"));
        $soutenances = $repo->findAll();
        $formSession = $this->createForm(SessionType::class, $session, ['soutenances' => $soutenances])
            ->add('saveAndModify', SubmitType::class, ['label' => 'Valider les modifications sur la soutenance et passer au résumé'])
            ->add('modifyetudiant', SubmitType::class, ['label' => 'Valider les modifications et modifier la liste des étudiants'])
            ->add('modifyjury', SubmitType::class, ['label' => 'Valider les modifications et modifier la liste des jurys'])
            ->add('skip', SubmitType::class, ['label' => 'Aller au résumé sans modifier la soutenance']);
        $formSession->handleRequest($request);


        // Création du session bag pour l'envoi de mail
        $sessionInterface->set("emailbagetudiant", []);
        $emailbag = $sessionInterface->get("emailbagetudiant", []);

        //si l'utilisateur ne souhaite pas modifier la soutenance et passer au résumé
        if($formSession->get('skip')->isClicked()){
            return $this->redirectToRoute('session_show', ['id' => $session->getId()]);
        }

        //Si l'utilisateur souhaite modifier la soutenance sans modifier les listes de mailing
        if ($formSession->isSubmitted() && $formSession->isValid() && $formSession->get('saveAndModify')->isClicked()) {

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

            return $this->redirectToRoute('session_show', ['id' => $session->getId()]);
        }


        //si l'utilisateur souhaite modifier la soutenance puis passer à la modification de la liste des étudiants
        if ($formSession->isSubmitted() && $formSession->isValid() && $formSession->get('modifyetudiant')->isClicked()) {

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

        //si l'utilisateur souhaite modifier la soutenance puis passer à la modification de la liste des jurys
        if ($formSession->isSubmitted() && $formSession->isValid() && $formSession->get('modifyjury')->isClicked()) {

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

            return $this->redirectToRoute('session_edit_jury', ['id' => $session->getId()]);
        }
        



        //si l'utilisateur ne souhaite pas modifier la soutenance
        if ($formSession->isSubmitted() && $formSession->isValid() && $formSession->get('save')->isClicked()){
            $manager->persist($session);
            $manager->flush();
            return $this->redirectToRoute('session_show', ['id' => $session->getId()]);
        }


        return $this->render('session/edit.html.twig', [
            'formSession' => $formSession->createView(),
        ]);
    }

    /**
     * @isGranted("ROLE_CREATOR", "ROLE_ADMIN")
     * @Route("/session/{id}/edit_etudiant", name="session_edit_etudiant")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param Session $session
     * @param SessionInterface $sessionInterface est un session bag pour gérer l'envoi de mail
     * @return RedirectResponse|Response
     */
    public function editEtudiant(Request $request, EntityManagerInterface $manager, SoutenanceRepository $repo, Session $session, SessionInterface $sessionInterface){


        //Upload listeEtudiant
        $sessionInterface->set("emailbagetudiant", []);
        $emailbag = $sessionInterface->get("emailbagetudiant", []);

        $fileEtudiant = new Upload();
        $formUploadListeEtudiant = $this->createForm(UploadType::class, $fileEtudiant)
        ->add('download', SubmitType::class, ['label' => 'Télécharger la liste des étudiants au format csv'])
        ->add('modifyetudiant', SubmitType::class, ['label' => 'Modifier la liste des étudiants et revenir au résumé'])
        ->add('modifyetudiant_into_modifyjury', SubmitType::class, ['label' => 'Modifier la liste des étudiants et passer à la modification de la liste des jurys'])
        ->add('modifyjury', SubmitType::class, ['label' => 'Passer à la modification de liste des jurys sans modifier la liste des étudiants'])
        ->add('skip', SubmitType::class, ['label' => 'Revenir au résumé']);
        $formUploadListeEtudiant->handleRequest($request);
        $row = '';


        // Si l'utilisateur se ravise et souhaite passer au résumé
        if($formUploadListeEtudiant->get('skip')->isClicked()){
            return $this->redirectToRoute('session_show', ['id' => $session->getId()]);
        }

        if($formUploadListeEtudiant->get('download')->isClicked()){
            $csv = writer::createFromFileObject(new \SplTempFileObject());
            $csv->insertOne(["nom","prenom","courriel", "groupe"]);
            $filecontent = $session->getListeEtudiant();
            $filecontent = explode("\n", $filecontent);
            $filecontent = array_reverse($filecontent);
            array_pop($filecontent);
            $filecontent = array_reverse($filecontent);
            array_pop($filecontent);

            foreach($filecontent as $tmp){

                $vide = "";
                $tab = explode(",",$tmp);
                $nom = $tab[0];

                $prenom = $tab[1];
                $prenom = str_replace(array(chr(34),chr(39)), $vide, $prenom);
                $courriel = $tab[2];
                $courriel = str_replace(array(chr(34),chr(39)), $vide, $courriel);

                $groupe = $tab[3];

                

                $csv->insertOne([$nom, $prenom, $courriel, $groupe]);
            }
            $csv->output('ListeEtudiant.csv');
            die('');
        }

        // si l'utilsateur souhaite modifier la liste des jurys après avoir modifié la liste des étudiants
        if ($formUploadListeEtudiant->isSubmitted() && $formUploadListeEtudiant->isValid() && $formUploadListeEtudiant->get('modifyetudiant_into_modifyjury')->isClicked() ) {
            $fileEtudiant->getName(); // file etudiant à des champs null 
            $sessionInterface->set("fileetudiant", $fileEtudiant->getName());
            $files = $formUploadListeEtudiant->get('name')->getData();
            //dump($files);

            $reader = Reader::createFromPath($files->getRealPath())->setHeaderOffset(0);

            $session->setListeEtudiant("Nom, Prénom, Courriel, Groupe : " . "\n");

            foreach ($reader as $row) {
                $session->setListeEtudiant($session->getListeEtudiant() . $row['nom'] . ",");
                $session->setListeEtudiant($session->getListeEtudiant() . $row['prenom'] . ",");
                $session->setListeEtudiant($session->getListeEtudiant() . $row['courriel'] . ",");
                $session->setListeEtudiant($session->getListeEtudiant() . $row['groupe'] . "\n");

                array_push($emailbag, $row['courriel']);
            }
            $sessionInterface->set("emailbagetudiant", $emailbag);
            $manager->persist($session);
            $manager->flush();
            return $this->redirectToRoute('session_edit_jury', ['id' => $session->getId()]);
        }

        // si l'utilisateur souhaite uniquement changer la liste des étudiants et passer au résumé
        if ($formUploadListeEtudiant->isSubmitted() && $formUploadListeEtudiant->isValid() && $formUploadListeEtudiant->get('modifyetudiant')->isClicked() ) {
            $fileEtudiant->getName(); // file etudiant à des champs null 
            $sessionInterface->set("fileetudiant", $fileEtudiant->getName());
            $files = $formUploadListeEtudiant->get('name')->getData();
            //dump($files);

            $reader = Reader::createFromPath($files->getRealPath())->setHeaderOffset(0);

            $session->setListeEtudiant("Nom, Prénom, Courriel, Groupe : " . "\n");

            foreach ($reader as $row) {
                $session->setListeEtudiant($session->getListeEtudiant() . $row['nom'] . ",");
                $session->setListeEtudiant($session->getListeEtudiant() . $row['prenom'] . ",");
                $session->setListeEtudiant($session->getListeEtudiant() . $row['courriel'] . ",");
                $session->setListeEtudiant($session->getListeEtudiant() . $row['groupe'] . "\n");

                array_push($emailbag, $row['courriel']);
            }
            $sessionInterface->set("emailbagetudiant", $emailbag);
            $manager->persist($session);
            $manager->flush();
            return $this->redirectToRoute('session_show', ['id' => $session->getId()]);
        }

        // si l'utilisateur souhaite changer la liste des jurys sans changer la liste des étudiants
        if($formUploadListeEtudiant->get('modifyjury')->isClicked()){
            return $this->redirectToRoute('session_edit_jury', ['id' => $session->getId()]);
        }


        return $this->render('session/editetudiant.html.twig', [
            'formUploadListeEtudiant' => $formUploadListeEtudiant->createView()
        ]);
    }



    /**
     * @isGranted("ROLE_CREATOR", "ROLE_ADMIN")
     * @Route("/session/{id}/edit_jury", name="session_edit_jury")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param Session $session
     * @param SessionInterface $sessionInterface est un session bag pour gérer l'envoi de mail
     * @return RedirectResponse|Response
     */
    public function editJury(Request $request, EntityManagerInterface $manager, SoutenanceRepository $repo, Session $session, SessionInterface $sessionInterface){

        //$sessionInterface->set("emailbagjury", []);
        $emailbag = $sessionInterface->get("emailbagjury", []);
            //Upload listeJury
            $fileJury = new Upload();
            $formUploadListeJury = $this->createForm(UploadType::class, $fileJury)
            ->add('download', SubmitType::class, ['label' => 'Télécharger la liste du jury au format csv'])
            ->add('modifyjury', SubmitType::class, ['label' => 'Modifier la liste des jurys et revenir au résumé'])
            ->add('modifyjury_into_modifyetudiant', SubmitType::class, ['label' => 'Modifier la liste des jurys et passer à la modification de la liste des étudiants'])
            ->add('modifyetudiant', SubmitType::class, ['label' => 'Passer à la modification de liste des étudiants sans modifier la liste des jurys'])
            ->add('skip', SubmitType::class, ['label' => 'Revenir au résumé']);
            $formUploadListeJury->handleRequest($request);

            // Si l'utilisateur se ravise et souhaite passer au résumé
            if($formUploadListeJury->get('skip')->isClicked()){
                return $this->redirectToRoute('session_show', ['id' => $session->getId()]);
            }

            if($formUploadListeJury->get('download')->isClicked()){
                $csv = writer::createFromFileObject(new \SplTempFileObject());
                $csv->insertOne(["nom","prenom","courriel"]);
                $filecontent = $session->getListeJury();
                $filecontent = explode("\n", $filecontent);
                $filecontent = array_reverse($filecontent);
                array_pop($filecontent);
                $filecontent = array_reverse($filecontent);
                array_pop($filecontent);

                foreach($filecontent as $tmp){

                    $vide = "";
                    $tab = explode(",",$tmp);
                    $nom = $tab[0];

                    $prenom = $tab[1];
                    $prenom = str_replace(array(chr(34),chr(39)), $vide, $prenom);
                    $courriel = $tab[2];
                    $courriel = str_replace(array(chr(34),chr(39)), $vide, $courriel);

                    

                    $csv->insertOne([$nom, $prenom, $courriel]);
                }
                $csv->output('ListeJury.csv');
                die('');
            }

            // si l'utilisateur souhaite uniquement changer la liste des jurys et passer au résumé
            if ($formUploadListeJury->isSubmitted() && $formUploadListeJury->isValid() && $formUploadListeJury->get('modifyjury')->isClicked()) {
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

            // si l'utilisateur souhaite changer la liste des jurys et puis modifier la liste des étudiants
            if ($formUploadListeJury->isSubmitted() && $formUploadListeJury->isValid() && $formUploadListeJury->get('modifyjury_into_modifyetudiant')->isClicked()) {
                $fileJury->getName(); // champs nulls ici aussi 
                $files = $formUploadListeJury->get('name')->getData();

                $reader = Reader::createFromPath($files->getRealPath())->setHeaderOffset(0);

                $session->setListeJury("Nom, Prénom, Courriel : \n");
                foreach ($reader as $row) {
                    $session->setListeJury($session->getListeJury() . $row['nom'] . ",");
                    $session->setListeJury($session->getListeJury() . $row['prenom'] . ",");
                    $session->setListeJury($session->getListeJury() . $row['courriel'] . "\n");
                    array_push($emailbag, $row['courriel']);
                }
                $sessionInterface->set("emailbagjury", $emailbag);
                $manager->persist($session);
                $manager->flush();
                return $this->redirectToRoute('session_edit_etudiant', ['id' => $session->getId()]);
            }
            // si l'utilisateur souhaite la liste des étudiants sans modifier la liste des jurys
            if ($formUploadListeJury->get('modifyetudiant')->isClicked()) {
                return $this->redirectToRoute('session_edit_etudiant', ['id' => $session->getId()]);
            }


            //dump($session->getListeJury());
            return $this->render('session/editjury.html.twig', [
                //'formSession' => $formSession->createView(),
                //'formUploadListeEtudiant' => $formUploadListeEtudiant->createView(),
                'formUploadListeJury' => $formUploadListeJury->createView(),
            ]);
        }

        /**
     * @isGranted("ROLE_CREATOR", "ROLE_ADMIN")
     * @Route("/session/{id}/mail", name="session_mail")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param Session $session
     * @param SessionInterface $sessionInterface est un session bag pour gérer l'envoi de mail
     * @return RedirectResponse|Response
     */
    public function mail(Request $request, EntityManagerInterface $manager, SoutenanceRepository $repo, Session $session, SessionInterface $sessionInterface){

        //dump($sessionInterface->get("emailbagetudiant"));
        $form = $this->createForm(FormMailType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){

            //envoi Mail étudiant 
            $emailbagetudiant = $sessionInterface->get("emailbagetudiant");
            $objetetudiant = $sessionInterface->get("objetetudiant");
            $texte_mail_etudiant = $sessionInterface->get("textemailetudiant");
            $manager = $this->getDoctrine()->getManager();


            foreach ($emailbagetudiant as $email){



                //traitement du mail à envoyer pour les étudiants   
                // Début Création de lien pour soutenance
                
                $tmp = $email;
                $prenom = explode(".",$tmp)[0];
                $nom = explode(".",explode("@",$tmp)[0])[1];
                $body = $texte_mail_etudiant;
                $body = str_replace("{{Prenom}}", $prenom, $body);
                $body = str_replace("{{Nom}}", $nom, $body);

                $user = $manager->getRepository(User::class)->findOneBy(['email' => $email]);
                if(!$user){
                    $user = new Peer();
                    $user->setEmail($email);
                    $user->setFirstName($prenom);
                    $user->setLastName($nom);
                    $user->setUid(sha1(random_bytes(10)));
                    $manager->persist($user);
                    $manager->flush();
                }

                $route = $this->generateUrl("login_with_uid", ['uid' => $user->getUid(), 'uidSession' => $session->getUid() ], false);

                $body = str_replace("{{Lien}}", $route, $body);

                

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

            $emailbagjury = $sessionInterface->get("emailbagjury");
            $objetjury = $sessionInterface->get("objetjury");
            $texte_mail_jury = $sessionInterface->get("textemailjury");

            foreach ($emailbagjury as $email){



                //traitement du mail à envoyer pour les étudiants
                $tmp = $email;
                $prenom = explode(".",$tmp)[0];
                $nom = explode(".",explode("@",$tmp)[0])[1];
                $body = $texte_mail_jury;
                $body = str_replace("{{Prenom}}", $prenom, $body);
                $body = str_replace("{{Nom}}", $nom, $body);

                $user = $manager->getRepository(User::class)->findOneBy(['email' => $email]);
                if(!$user){
                    $user = new Peer();
                    $user->setEmail($email);
                    $user->setFirstName($prenom);
                    $user->setLastName($nom);
                    $user->setUid(sha1(random_bytes(10)));
                    $manager->persist($user);
                    $manager->flush();
                }

                $route = $this->generateUrl("login_with_uid", ['uid' => $user->getUid(), 'uidSession' => $session->getUid() ], false);

                $body = str_replace("{{Lien}}", $route, $body);

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


                $mail->Subject = $objetjury;
                $mail->Body = $body;

                $mail->send();
            }



            
            return $this->redirectToRoute('session_show', ['id' => $session->getId()]);
        }
        return $this->render('session/mail.html.twig', [
            'formmail'=>$form->createView()
        ]);
    }
    
    

}
