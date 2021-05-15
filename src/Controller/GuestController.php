<?php

namespace App\Controller;

// Required for a controller.
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// Requests and responses handling
use Symfony\Component\HttpFoundation\Response;

// Route annotations
use Symfony\Component\Routing\Annotation\Route;

/**
* Ce contrôleur gère les routes suivantes : (toutes les routes commençant par "/guest", soit tout ce qui concerne les 
* utilisateurs non authentifiés [les pairs et les membres de jurys]).
* Notation : <chemin> : "<nom_de_la_route>" (<explications>)
* 
* /guest : "guest" (La porte d'entrée de la partie de l'application réservée aux pairs et aux membres de jurys. C'est à cet endroit 
* qu'il pourront rejoindre les sessions de soutenances auxqelles ils sont invités. On peut imaginer qu'ils soient invités à renseigner 
* un identifiant de session et un mot de passe personnel permettant de les identifier - ces deux 
* informations leur ayant été fournies par mail)
* -------------------------------------
*
* @Route("/guest")
*/
class GuestController extends AbstractController {

    /**
     * @Route("", name="guest")
     */
    public function index(): Response {

        return $this->render('guest/index.html.twig');

    }

}