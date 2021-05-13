<?php

namespace App\Entity;

// Routes annotations
use Doctrine\ORM\Mapping as ORM;

// Other dependencies
use App\Security\Role;

/**
 * @ORM\Entity
 * 
 * Classe représentant les administrateurs de COS.
 */
class Admin extends LoggedUser {

    public function __construct() {
        
        parent::__construct();
        $this->addRole(Role::ADMIN);

    }
    
}