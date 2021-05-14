<?php

namespace App\Controller;

// Required for a controller.
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// Requests and responses handling
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

// Route annotations
use Symfony\Component\Routing\Annotation\Route;

// Other dependencies
use App\Entity\AccountRequest;
use App\Repository\AccountRequestRepository;
use App\Security\Status;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

/**
 * Ce contrôleur gère les routes suivantes : (toutes les routes commençant par "/admin", soit tout ce qui concerne les 
 * administrateurs de COS)
 * Notation : <chemin> : "<nom_de_la_route>" (<explications>)
 * 
 * /admin : "admin" (La porte d'entrée de la partie de l'application réservée aux administrateurs de COS)
 *
 * /admin/account-request/{id} : "show_account_request" (Permet de consulter les détails d'une demande de création de 
 * compte organisateur)
 *
 * /admin/account-request/{id}/validate : "validate_account_request" (Permet de valider une demande de création 
 * de compte organisateur)
 *
 * /admin/account-request/{id}/decline : "decline_account_request" (Permet de décliner une demande de création 
 * de compte organisateur)
 * -------------------------------------
 *
 * @Route("/admin")
 */
class AdminController extends AbstractController
{

    /**
     * @Route("", name="admin")
     */
    public function index(AccountRequestRepository $accountRequestRepository): Response
    {

        return $this->render('admin/index.html.twig', ['account_requests' => $accountRequestRepository->findBy(["status" => Status::PENDING])]);
    }

    /**
     * @Route("/account-request/{id}", name="show_account_request")
     */
    public function showRequest(AccountRequest $accountRequest): Response
    {

        return $this->render('admin/show_request.html.twig', ['account_request' => $accountRequest]);
    }

    /**
     * @Route("/account-request/{id}/validate", name="validate_account_request")
     */
    public function validateRequest(AccountRequest $accountRequest, MailerInterface $mailer): Response
    {

        $accountRequest->setStatus(Status::VALIDATED);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($accountRequest);
        $entityManager->flush();

        $email = new Email();
        $email
            ->from('ne-pas-repondre@COS.com')
            ->to($accountRequest->getEmail())
            ->subject('COS : Réponse à votre demande de création de compte organisateur')
            ->text(
                "Votre demande de création de compte organisateur a été validée !\n\n" .
                    "Suivez le lien suivant pour finaliser la création de votre compte :\n" .
                    $this->generateUrl('complete_registration', ['id' => $accountRequest->getId()], false)
            );

        $mailer->send($email);

        return $this->redirectToRoute('admin');
    }

    /**
     * @Route("/account-request/{id}/decline", name="decline_account_request")
     */
    public function declineRequest(AccountRequest $accountRequest): Response
    {

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($accountRequest);
        $entityManager->flush();

        return $this->redirectToRoute('admin');
    }
    
}
