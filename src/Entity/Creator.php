<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * 
 * Class for orals organizers/creators
 */
class Creator extends LoggedUser {

    public function __construct() {parent::__construct();}

}