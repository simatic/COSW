<?php

namespace App\Security;

/**
 * Définit les rôles des utilisateurs sous forme 
 * de constantes statiques.
 */
abstract class Role {

    public const USER = "ROLE_USER";
    public const ADMIN = "ROLE_ADMIN";
    public const GUEST = "ROLE_GUEST";
    public const CREATOR = "ROLE_CREATOR";

}