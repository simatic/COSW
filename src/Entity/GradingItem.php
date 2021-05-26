<?php

namespace App\Entity;

// Doctrine annotations
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * 
 * Classe représentant les items de notation (évaluables atomiques).
 * Les items de notation sont inclus dans des rubriques, elles-même 
 * incluses dans des fiches d'évaluation.
 */
class GradingItem extends Gradable {

    /**
     * 
     * La rubrique dans laquelle est incluse l'item.
     */
    private $gradingRubric;

    public function __construct()
    {
        parent::__construct();
    }

}