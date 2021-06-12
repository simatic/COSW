<?php

namespace App\Controller;

// Required for a controller.
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// Requests and responses handling
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

// Route annotations
use Symfony\Component\Routing\Annotation\Route;

// Other dependencies.
use App\Entity\Creator;
use App\Form\CreatorType;
use App\Entity\AccountRequest;
use App\Form\AccountRequestType;
use App\Repository\AccountRequestRepository;
use App\Security\Status;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

/**
* Ce contrôleur gère les routes suivantes : (toutes les routes commençant par "/register")
* Notation : <chemin> : "<nom_de_la_route>" (<explications>)
* 
* /register : "register" (Pour faire une demande de création de compte organisateur)
*
* /register/complete-registration : "complete_registration" (Pour finaliser la création d'un compte organisateur 
* un fois que la demande a été validée. L'utilisateur finalise la création de son compte en définissant un 
* mot de passe.)
* -------------------------------------
*
* @Route("/register")
*/
class RegistrationController extends AbstractController {

    /**
     * @Route("", name="register")
     */
    public function register(Request $request, AccountRequestRepository $accountRequestRepository): Response {
        
        $accountRequest = new AccountRequest();

        $form = $this->createForm(AccountRequestType::class, $accountRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if($accountRequestRepository->findBy(['email' => $form->get("email")->getData()])) {throw new \Exception("Une demande a déjà été formulée pour cette adresse mail.");}

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($accountRequest);
            $entityManager->flush();

            return $this->redirectToRoute('home');

        }

        return $this->render('registration/request.html.twig', ['form' => $form->createView(), 'button_label' => 'Envoyer ma demande']);

    }

    /**
     * @Route("/complete-registration/{id}", name="complete_registration")
     */
    public function completeRegistration(Request $request, AccountRequest $accountRequest, UserPasswordEncoderInterface $encoder, GuardAuthenticatorHandler $gard) {
        
        if($accountRequest->getStatus() != Status::VALIDATED) {

            return $this->render('registration/pending_request.html.twig');

        }

        $creator = new Creator();

        $creator->setFirstName($accountRequest->getFirstName());
        $creator->setLastName($accountRequest->getLastName());
        $creator->setEmail($accountRequest->getEmail());

        $form = $this->createForm(CreatorType::class, $creator);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $creator->setPassword($encoder->encodePassword($creator, $form->get('password')->getData()));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($creator);
            $entityManager->remove($accountRequest);
            $entityManager->flush();

            return $this->redirectToRoute('home');

        }

        return $this->render('registration/complete.html.twig', ['form' => $form->createView(), 'button_label' => 'Valider']);

    }

}