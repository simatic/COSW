<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// Requests and responses handling
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

// Route annotations
use Symfony\Component\Routing\Annotation\Route;

// Log in
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

// Registration
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Form\RegistrationFormType;
use App\Entity\Creator;

// Creator account requests
use App\Entity\AccountRequest;
use App\Form\AccountRequestType;
use App\Repository\AccountRequestRepository;
use App\Security\Status;
use App\Repository\UserRepository;

// URL access control
// use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class Controller extends AbstractController
{
    /**
     * @Route("", name="home")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }

    /**
     * @Route("/creator/dashboard", name="creator_dashboard")
     */
    public function greetCreator(): Response {

        return new Response("<h1>Hello man!</h1>");

    }

    /**
     * @Route("/login/{type}", name="login", defaults={"type": "log-in-or-sign-in"})
     */
    public function login(String $type, AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error, 'type' => $type]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request): Response {
        
        $accountRequest = new AccountRequest();
        $form = $this->createForm(AccountRequestType::class, $accountRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($accountRequest);
            $entityManager->flush();

            return $this->redirectToRoute('home');

        }

        return $this->render('account_request/new.html.twig', [
            'form' => $form->createView(),
            'button_label' => 'Envoyer ma demande'
        ]);
    }

    /**
     * @Route("admin-dashboard/account-requests", name="account_request_index", methods={"GET"})
     */
    public function indexRequests(AccountRequestRepository $accountRequestRepository): Response
    {
        return $this->render('account_request/index.html.twig', [
            'account_requests' => $accountRequestRepository->findBy(["status" => Status::PENDING]),
        ]);
    }

    /**
     * @Route("/invite", name="account_request_new", methods={"GET","POST"})
     * 
     */
    public function newRequest(UserRepository $userRepository, Request $request): Response
    {
        $accountRequest = new AccountRequest();
        $form = $this->createForm(AccountRequestType::class, $accountRequest, ['invite' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Attention, ne rechercher que parmi les creators ici : code à modifier (UserRepository).
            if($userRepository->findBy(['email' => $form->get("email")->getData()])) {throw new \Exception("Cette adresse email est déjà associée à un compte organisateur.");}

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($accountRequest);
            $entityManager->flush();

            return $this->redirectToRoute('account_request_index');
        }

        return $this->render('account_request/new.html.twig', [
            'form' => $form->createView(),
            'button_label' => 'Envoyer une invitation'
        ]);
    }

    /**
     * @Route("admin-dashboard/account-requests/{id}", name="account_request_show", methods={"GET"})
     */
    public function showRequest(AccountRequest $accountRequest): Response
    {
        return $this->render('account_request/show.html.twig', [
            'account_request' => $accountRequest,
        ]);
    }

    /**
     * @Route("admin-dashboard/account-requests/{id}/edit", name="account_request_edit", methods={"GET","POST"})
     */
    public function editRequest(Request $request, AccountRequest $accountRequest): Response
    {
        $form = $this->createForm(AccountRequestType::class, $accountRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('account_request_index');
        }

        return $this->render('account_request/edit.html.twig', [
            'account_request' => $accountRequest,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("admin-dashboard/account-requests/{id}/delete", name="account_request_delete", methods={"DELETE"})
     */
    public function deleteRequest(Request $request, AccountRequest $accountRequest): Response
    {
        if ($this->isCsrfTokenValid('delete'.$accountRequest->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($accountRequest);
            $entityManager->flush();
        }

        return $this->redirectToRoute('account_request_index');
    }

    /**
     * @Route("admin-dashboard/account-requests/{id}/validate", name="account_request_validate", methods={"GET"})
     */
    public function validateRequest(Request $request, AccountRequest $accountRequest): Response {

        $accountRequest->setStatus(Status::VALIDATED);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($accountRequest);
        $entityManager->flush();
        
        // Send a mail here

        return $this->redirectToRoute('account_request_index');

    }

}
