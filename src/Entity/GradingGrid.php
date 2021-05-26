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
class GradingGrid extends Gradable {

    /**
     * 
     * La session de soutenances à laquelle est rattachée la fiche d'évaluation.
     */
    private $oral;

    /**
     * 
     * Définit la stratégie à adopter pour considérer qu'une fiche 
     * d'évaluation est complète ou non.
     * cf. CompletionPolicy.php.
     * Doit être une constante définie dans /src/Utilities/CompletionPolicy.php.
     */
    private int $completionPolicy;

    /**
     * 
     * La part de l'évaluation des pairs dans la 
     * note finale attribuée aux soutenances d'une 
     * même session.
     * Il s'agit d'une proportion (nombre réel compris entre 0 et 1).
     * La part de l'évaluation des membres du jury comptant 
     * dans la note finale des soutenances d'une même session est donc 
     * 1 - $peerWeighting.
     */
    private float $peerWeighting;

    public function __construct()
    {
        parent::__construct();
    }

}