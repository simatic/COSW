<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * 
 * Class for logged users (administrators and orals organizers/creators)
 */
abstract class LoggedUser extends User {

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    public function __construct() {parent::__construct();}

    /**
     * Overrides User::getPassword()
     */
    public function getPassword() {return $this->password;}

    // Sets the hashed/encoded password
    public function setPassword(String $password) {$this->password = $password;}

}