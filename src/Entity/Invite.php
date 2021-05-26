<?php

namespace App\Entity;

// Doctrine annotations
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * 
 * Classe représentant les invitations d'utilisateurs à 
 * des sessions de soutenances.
 * Il existe au plus une invitation par couple 
 * ($session, $user).
 * Chaque invitation est référencée par un UUID
 * (Universally Unique Identifier), utilisé pour 
 * rediriger un utilisateur vers la session de soutenances à 
 * laquelle il a été invité.
 */
class Invite {

    /**
     * 
     * La session concernée par l'invitation.
     */
    private $session;

    /**
     * 
     * L'utilisateur invité.
     */
    private $user;

    /**
     * 
     * L'UUID identifiant l'invitation.
     */
    private $uuid;

    public function __construct() 
    {

    }
    
}