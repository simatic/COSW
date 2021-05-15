<?php

namespace App\Entity;

// Doctrine annotations
use Doctrine\ORM\Mapping as ORM;

// Other dependencies
use App\Security\Role;

/**
 * @ORM\Entity
 * 
 * Classe représentant les administrateurs de COS.
 * Les administrateurs sont des utilisateurs authentifiés.
 */
class Admin extends LoggedUser {

    public function __construct() {
        
        parent::__construct();
        $this->addRole(Role::ADMIN);

    }
    
}