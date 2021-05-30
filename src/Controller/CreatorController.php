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
use App\Entity\User;
use App\Form\AccountRequestType;
use App\Form\EmailConnectionType;
use App\Repository\AccountRequestRepository;
use App\Security\Status;
use Exception as GlobalException;
use FFI\Exception as FFIException;
use Symfony\Component\Config\Definition\Exception\Exception as ExceptionException;
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

        $usertest = $this->getDoctrine()
            ->getRepository(User::class)
            ->findBy(['email' => "zaki.biroum@telecom-sudparis.eu"])[0];

        dump($usertest);
        //$Balises = ["{{Debut_objet_courriel}}", "{{Fin_objet_courriel}}", "{{Prenom}}", "{{Nom}}", "{{Lien}}"];
        $form = $this->createForm(EmailConnectionType::class);
        $form->handleRequest($request);

        dump($form);

        if ($form->isSubmitted() && $form->isValid()) {

            
            
            $creator = $session->get("creator",[]);
            $creator["email"] = $form->get("email")->getData();
            $creator["password"] = $form->get("password")->getData();
            
            $creator["texte_email_etudiant"] = $form->get("texte_email_etudiant")->getData();

            /**
             * Traitement de la chaïne de caractère où l'on remplace les balise par les éléments des Users
             */
            try{

            //on récupère l'objet du mail
            $objet = $form->get("texte_email_jury")->getData();
            $objet = explode("{{Debut_objet_courriel}}", $objet)[1];
            $objet = explode("{{Fin_objet_courriel}}", $objet)[0];
            $creator["objet"] = $objet;

            // on récupère le body du mail jury 
            $texte_mail_jury = $form->get("texte_email_jury")->getData();
            $texte_mail_jury = explode("{{Fin_objet_courriel}}", $form->get("texte_email_jury")->getData())[1];
            

            //on remplace les balises dans le body du mail jury 
            $texte_mail_jury = str_replace("{{Prenom}}", $usertest->getFirstname(), $texte_mail_jury);
            $texte_mail_jury = str_replace("{{Nom}}", $usertest->getLastname(), $texte_mail_jury);
        
            $creator["texte_email_jury"] = $texte_mail_jury;
            

            // on récupère le body du mail étudiant 
            $texte_mail_etudiant = $form->get("texte_email_etudiant")->getData();
            $texte_mail_etudiant = explode("{{Fin_objet_courriel}}", $form->get("texte_email_etudiant")->getData())[1];
            $texte_mail_etudiant = str_replace("{{Prenom}}", $usertest->getFirstname(), $texte_mail_etudiant);
            $texte_mail_etudiant = str_replace("{{Nom}}", $usertest->getLastname(), $texte_mail_etudiant);

            $creator["texte_email_etudiant"] = $texte_mail_etudiant;


            }
            catch(GlobalException $e){
                $this->addFlash("notice","Veuillez remplir les champs de mails correctements en faisaint attention aux balises");
                return $this->redirectToRoute('mailing', ['request' => $request]);
            }

            


            $session->set('creator', $creator);
            


            return $this->redirectToRoute('mailinglist', ['request' => $request]);




        }
        return $this->render('creator/email.html.twig', ['form' => $form->createView(), 'button_label' => 'Connexion', '']);

    }
    

    /**
     * Controller pour la mailing list des étudiants pour la soutenance
     * @Route("/mailinglist", name="mailinglist")
     */
    public function MailingList(SessionInterface $session, Request $request): Response {

        $date = ""; //to set
        $mail = new PHPMailer(true);
        $mail->Encoding = 'base64';
        $mail ->CharSet = "UTF-8";
        try{
            //Server settings
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'z.mines-telecom.fr';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $creator = $session->get("creator");
            dump($creator);
            $array = array_values($creator);
            dump($array);
            $mail->Username   = $creator["email"];
            $mail->Password   = $creator["password"];

            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;           
        
            //Recipients
            $mail->setFrom('ne-pas-repondre@COS.com', 'Soutenance COS'.$date);
            $mail->addAddress($creator["email"]);
        
        
            //Content
            $mail->Subject = $creator["objet"];
            $mail->Body    = $creator["texte_email_jury"];
        
            $mail->send();
            $this->addFlash("notice","vous êtes bien connecté au serveur Zimbra, uploader la liste des élèves à contacter pour la session de soutenance au format excel");
        }
        catch(Exception $e){
            $this->addFlash("notice","impossible de vous connecter au serveur de mail, veuillez réessayer");
            return $this->redirectToRoute('mailing', ['request' => $request]);
        }

        return $this->render('creator/mailinglist.html.twig');
    }



}