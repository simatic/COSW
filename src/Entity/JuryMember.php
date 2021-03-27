<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * 
 * Class for jury members
 */
class JuryMember extends Guest {

    public function __construct() {parent::__construct();}
    
}