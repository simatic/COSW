<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * 
 * Class for peers
 */
class Peer extends Guest {

    /**
     * @var string|null A custom username chosen by the peer when they open the app
     * @ORM\Column(name="username", type="string", length=30)
     */
    private $username;

    public function __construct() {parent::__construct();}

    /**
     * Overrides User::getUsername()
     */
    public function getUsername() {return $this->username;}

    public function setUsername(String $username) {$this->username = $username;}

}