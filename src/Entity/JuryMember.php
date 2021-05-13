<?php

namespace App\Entity;

// Doctrine annotations
use Doctrine\ORM\Mapping as ORM;

// Other dependencies
use App\Security\Role;

/**
 * @ORM\Entity
 * 
 * Classe représentant les membres du jury.
 * Les membres du jury sont des utilisateurs non authentifiés ("guests").
 */
class JuryMember extends Guest {

    public function __construct() {
        
        parent::__construct();
        $this->addRole(Role::JURY);
    
    }
    
}