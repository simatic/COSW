<?php

namespace App\Controller;

// Required for a controller.
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// Requests and responses handling
use Symfony\Component\HttpFoundation\Response;

// Route annotations
use Symfony\Component\Routing\Annotation\Route;

// Other dependencies
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
* Ce contrôleur gère les routes suivantes :
* Notation : <chemin> : "<nom_de_la_route>" (<explications>)
* 
* / : "home" (La page d'accueil du site)
*
* /login : "login" (Pour se connecter [seulement pour les organisateurs de soutenances et les administrateurs de COS])
*
* /logout : "logout" (Pour se déconnecter)
*/
class HomeController extends AbstractController {


    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response {

        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('home/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);

    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout() {

        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
        
    }

    /**
     * @Route("reset-password", name="password_reset_request")
     */
    public function resetRequest() {



    }

}