<?php

namespace App\Entity;

// Doctrine annotations.
use Doctrine\ORM\Mapping\Annotation as ORM;

/**
 * 
 * Classe représentant l'évaluation d'un évaluable 
 * (instances de "Gradable") par un utilisateur.
 * Il existe au plus une instance de Grading par couple 
 * ($gradable, $user).
 */
class Grading {

    /**
     * 
     * L'évaluable évalué.
     */
    private Gradable $gradable;

    /**
     * 
     * L'utilisateur ayant réalisé 
     * l'évaluation.
     */
    private User $user;

    /**
     * 
     * La note donnée à l'évaluable.
     */
    private float $grade;

    /**
     * 
     * Un commentaire optionnel accompagnant 
     * la note.
     */
    private string $comment;

    public function __construct()
    {
        
    }

}