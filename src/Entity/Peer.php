<?php

namespace App\Entity;

// Doctrine annotations
use Doctrine\ORM\Mapping as ORM;

// Other dependencies
use App\Security\Role;

/**
 * @ORM\Entity
 * 
 * Classe représentant les pairs/étudiants.
 * Les pairs sont des utilisateurs non authentifiés ("guests").
 */
class Peer extends Guest {

    /**
     * @var string|null A custom username chosen by the peer when they open the app
     * @ORM\Column(name="username", type="string", length=30)
     */
    private $username;

    public function __construct() {
        
        parent::__construct();
        $this->addRole(Role::PEER);
    
    }

    /**
     * Overrides User::getUsername()
     */
    public function getUsername() {return $this->username;}

    public function setUsername(String $username) {$this->username = $username;}

}