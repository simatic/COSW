<?php

namespace App\Entity;

// Doctrine annotations
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * 
 * Classe représentant les rubriques des fiches d'évaluation.
 * Les rubriques sont en particulier des évaluables.
 */
class GradingRubric extends Gradable {

    /**
     * 
     * La fiche d'évaluation dans laquelle la rubrique est incluse.
     */
    private $gradingGrid;

    public function __construct()
    {
        parent::__construct();
    }

}