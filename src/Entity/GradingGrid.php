<?php

namespace App\Entity;

// Doctrine annotations
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * 
 * Classe représentant les fiches d'évaluation 
 * (qui sont des évaluables).
 */
class Creator extends Gradable {

    // La soutenance à laquelle est rattachée la fiche d'évaluation
    private $oral;

    // Définit la stratégie à adopter pour considérer qu'une fiche 
    // d'évaluation est complète ou non.
    // cf. CompletionPolicy.php.
    private int $completionPolicy;

    public function __construct()
    {
        parent::__construct();
    }

}