<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * 
 * Class for administrators
 */
class Admin extends LoggedUser {

    public function __construct() {parent::__construct();}
    
}