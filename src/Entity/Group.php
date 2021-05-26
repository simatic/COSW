<?php

namespace App\Entity;

// Doctrine annotations.
use Doctrine\ORM\Mapping\Annotation as ORM;

/**
 * 
 * Classe représentant une association d'utilisateurs
 * lors d'une session de soutenanace. Les pairs, comme les 
 * membres du jury peuvent s'associer en groupe.
 * Les membres d'un même groupe ne remplissent qu'une 
 * fiche d'évaluation par soutenance.
 */
class Group {

    /**
     * 
     * La session de soutenances pour laquelle le groupe 
     * a été formé.
     */
    private $session;

    /**
     * 
     * Les utilisateurs dans le groupe.
     */
    private $users;

    public function __construct()
    {
        
    }

}