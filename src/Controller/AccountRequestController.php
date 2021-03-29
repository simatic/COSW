<?php

namespace App\Controller;

use App\Entity\AccountRequest;
use App\Form\AccountRequestType;
use App\Repository\AccountRequestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Security\Status;

use App\Repository\UserRepository;

class AccountRequestController extends AbstractController
{
    /**
     * @Route("admin-dashboard/account-requests", name="account_request_index", methods={"GET"})
     */
    public function index(AccountRequestRepository $accountRequestRepository): Response
    {
        return $this->render('account_request/index.html.twig', [
            'account_requests' => $accountRequestRepository->findBy(["status" => Status::PENDING]),
        ]);
    }

    /**
     * @Route("register/account-request", name="account_request_new", methods={"GET","POST"})
     */
    public function new(UserRepository $userRepository, Request $request): Response
    {
        $accountRequest = new AccountRequest();
        $form = $this->createForm(AccountRequestType::class, $accountRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if($userRepository->findBy(['email' => $form->get("email")->getData()])) {throw new \Exception("user already exists");}

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($accountRequest);
            $entityManager->flush();

            return $this->redirectToRoute('account_request_index');
        }

        return $this->render('account_request/new.html.twig', [
            'account_request' => $accountRequest,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("admin-dashboard/account-requests/{id}", name="account_request_show", methods={"GET"})
     */
    public function show(AccountRequest $accountRequest): Response
    {
        return $this->render('account_request/show.html.twig', [
            'account_request' => $accountRequest,
        ]);
    }

    /**
     * @Route("admin-dashboard/account-requests/{id}/edit", name="account_request_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, AccountRequest $accountRequest): Response
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
    public function delete(Request $request, AccountRequest $accountRequest): Response
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
    public function validate(Request $request, AccountRequest $accountRequest): Response {

        $accountRequest->setStatus(Status::VALIDATED);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($accountRequest);
        $entityManager->flush();
        
        // Send a mail here

        return $this->redirectToRoute('account_request_index');

    }

}
