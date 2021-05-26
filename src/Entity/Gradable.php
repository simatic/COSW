<?php

namespace App\Entity;

// Doctrine annotations
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * 
 * Classe représentant toute entité évaluable d'une 
 * fiche d'évaluation. Cette classe représente donc aussi bien les items d'évaluation 
 * que les rubriques dans lesquelles ils sont regroupés, et les fiches d'évaluation 
 * de manière générale.
 * Les instances de cette classe stockent les noms et descriptions des entités 
 * évaluables, mais aussi le nombre de points sur lequel ces évaluables sont 
 * notés.
 */
class Gradable {

    private int $id;

    private string $name;

    private string $description;

    private float $highestGrade;

    private float $averageGrade;

    public function __construct() {}

}