<?php

namespace App\Controller;

// Required for a controller.
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// Requests and responses handling
use Symfony\Component\HttpFoundation\Response;

// Route annotations
use Symfony\Component\Routing\Annotation\Route;

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

}