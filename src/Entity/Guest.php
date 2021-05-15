<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * 
 * Class for unlogged users (peers and jury members)
 */
abstract class Guest extends User {

    public function __construct() {parent::__construct();}
    
}