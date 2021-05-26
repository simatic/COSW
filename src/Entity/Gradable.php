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
abstract class Gradable {

    /**
     * 
     * L'identifiant de l'évaluable.
     * Clé primaire dans la BDD.
     */
    private int $id;

    /**
     * 
     * Le nom de l'évaluable.
     */
    private string $name;

    /**
     * 
     * La description textuelle de 
     * l'évaluable.
     */
    private string $description;

    /**
     * 
     * Le barême de l'évaluable
     * (nombre de point sur lequel il est noté).
     */
    private float $highestGrade;

    /**
     * 
     * La moyenne des notes données à l'évaluable
     * par les membres du jury.
     * Peut être null.
     * Si vaut null, soit aucune note n'a été donnée, soit 
     * la notation des sous-évaluables de l'évaluable (items dans une rubrique par exemple) 
     * ne répond pas aux contraintes imposées par la completionPolicy de la fiche 
     * d'évaluation (classe GradingGrid).
     */
    private float $JuryAverageGrade;

    /**
     * 
     * La moyenne des notes données à l'évaluable
     * par les pairs.
     * Peut être null.
     * Si vaut null, soit aucune note n'a été donnée, soit 
     * la notation des sous-évaluables de l'évaluable (items dans une rubrique par exemple) 
     * ne répond pas aux contraintes imposées par la completionPolicy de la fiche 
     * d'évaluation (classe GradingGrid).
     */
    private float $PeerAverageGrade;

    public function __construct() {}

}