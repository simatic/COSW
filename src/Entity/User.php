<?php

namespace App\Entity;

// See /Security/Users.php
use App\Security\Role;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;

/**
 * @ORM\Entity
 * @ORM\Table(name="Users")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"logged" = "LoggedUser", "guest" = "Guest", "admin" = "Admin", "creator" = "Creator", "peer" = "Peer", "jury" = "JuryMember"})
 * 
 * Generic user class
 */
abstract class User implements UserInterface {

    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=50)
     */
    private $firstName;

    /**
     * @var string
     * @ORM\Column(type="string", length=50)
     */
    private $lastName;

    /**
     * @var string
     * @ORM\Column(type="string", unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles;

    public function __construct() {

        $this->roles = array(Role::USER);

    }

    public function getId() {return $this->id;}

    public function getFirstName() {return $this->firstName;}

    public function setFirstName(String $name) {$this->firstName = $name;}

    public function getLastName() {return $this->lastName;}

    public function setLastName(String $name) {$this->lastName = $name;}

    public function getEmail() {return $this->email;}

    public function setEmail(string $email) {$this->email = $email;}

    // Required by the UserInterface interface
    public function getRoles() {return array_unique($this->roles);}

    // $role has to be a constant defined in the Role class (Security/Roles.php).
    public function addRole(String $role) {

        // Ensures every user is at least granted a user role.
        $this->roles[] = Role::USER;

        $this->roles[] = $role;

        $this->roles = array_unique($this->roles);

    }

    // $role has to be a constant defined in the Role class (Security/Roles.php).
    public function removeRole(String $role) {

        if($role !== Role::USER) {$this->roles = array_diff($this->roles, array($role));}

    }

    // Required by the UserInterface interface
    public function getPassword() {}

    // Required by the UserInterface interface
    /**
     * Returns the salt that was originally used to hash the password.
     *
     * This can return null if the password was not hashed using a salt.
     *
     * This method is deprecated since Symfony 5.3, implement it from {@link LegacyPasswordAuthenticatedUserInterface} instead.
     *
     * @return string|null The salt
     */
    public function getSalt() {}

    // Required by the UserInterface interface
    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername() {}

    // Required by the UserInterface interface
    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials() {}

}