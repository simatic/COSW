<?php

namespace App\Controller;

// Required for a controller.
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// Requests and responses handling
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

// Route annotations
use Symfony\Component\Routing\Annotation\Route;

//Mailing depedencies
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;



// Other dependencies.
use App\Entity\Creator;
use App\Form\CreatorType;
use App\Entity\AccountRequest;
use App\Form\AccountRequestType;
use App\Form\EmailConnectionType;
use App\Repository\AccountRequestRepository;
use App\Security\Status;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
* Ce contrôleur gère les routes suivantes : (toutes les routes commençant par "/creator", soit tout ce qui concerne les 
* organisateurs de soutenances)
* Notation : <chemin> : "<nom_de_la_route>" (<explications>)
* 
* /creator : "creator" (La porte d'entrée de la partie de l'application réservée aux organisateurs de soutenances)
* -------------------------------------
*
* @Route("/creator")
*/
class CreatorController extends AbstractController {

    /**
     * @Route("", name="creator")
     */
    public function index(): Response {

        return $this->render('creator/index.html.twig');

    }

    /**
     * Controller pour la connexion au mail Zimbra afin de commencer la chaine de mailing à un esoutenance
     * @Route("/mailing", name="mailing")
     */
    public function Connectionmailing(SessionInterface $session, Request $request): Response {

        
        
        $form = $this->createForm(EmailConnectionType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            
            
            $creator = $session->get("creator",[]);

            $creator["email"] = $form->get("email")->getData();
            $creator["password"] = $form->get("password")->getData();

            $session->set('creator', $creator);
            return $this->redirectToRoute('mailinglist', ['request' => $request]);




        }
        return $this->render('creator/email.html.twig', ['form' => $form->createView(), 'button_label' => 'Connexion']);

    }
    

    /**
     * Controller pour la mailing list des étudiants pour la soutenance
     * @Route("/mailinglist", name="mailinglist")
     */
    public function MailingList(SessionInterface $session, Request $request): Response {

        $mail = new PHPMailer(true);

        try{
            //Server settings
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'z.mines-telecom.fr';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $creator = $session->get("creator");
            $array = array_values($creator);
            $mail->Username   = $array[0];
            $mail->Password   = $array[1];

            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
        
            //Recipients
            $mail->setFrom('ne-pas-repondre@COS.com', 'Mailer');
            $mail->addAddress('biroumzaki@gmail.com');
        
        
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Test';
            $mail->Body    = 'Test';
        
            $mail->send();
            $this->addFlash("notice","vous êtes bien connecté au serveur Zimbra, uploader la liste des élèves à contacter pour la session de soutenance au format excel");
        }
        catch(Exception $e){
            $this->addFlash("notice","impossible de vous connecter au serveur de mail, veuillez réessayer");
            return $this->redirectToRoute('mailing', ['request' => $request]);
        }

        return $this->render('creator/mailinglist.html.twig', ["mdp"=> $session->get("password"), "email"=> $session->get("email") ]);
    }



}