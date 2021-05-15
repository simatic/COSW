<?php

namespace App\Entity;

// Doctrine annotations
use Doctrine\ORM\Mapping as ORM;

// Other dependencies
use App\Security\Role;

/**
 * @ORM\Entity
 * 
 * Classe représentant les organisateurs de soutenances.
 * Les organisateurs de soutenances sont des utilisateurs authentifiés.
 */
class Creator extends LoggedUser {

    public function __construct() {
        
        parent::__construct();
        $this->addRole(Role::CREATOR);
    
    }

}