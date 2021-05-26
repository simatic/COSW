<?php

namespace App\Entity;

// Doctrine annotations
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * 
 * Classe représentant les soutenanaces.
 */
class Oral {

    /**
     * 
     * L'identifiant de la soutenance.
     * Clé primaire dans la BDD.
     */
    private int $id;

    /**
     * 
     * La session à laquelle appartient la soutenanace.
     */
    private $session;

    /**
     * 
     * La date de début de la soutenance.
     */
    private $startDate;

    /**
     * 
     * La date de fin de la soutenance.
     */
    private $endDate;

    /**
     * 
     * Les pairs évalués lors de la soutenance.
     * (nom à changer éventuellement).
     */
    private $peers;

    public function __construct() 
    {
        
    }
    
}