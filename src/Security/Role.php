<?php

namespace App\Security;

/**
 * Définit les rôles des utilisateurs sous forme 
 * de constantes statiques.
 */
abstract class Role {

    // Rôle par défaut de toute personne utilisant l'application COS.
    public const USER = "ROLE_USER";
    // Les administrateurs de COS (valident les demandes de création de comptes d'organisateur de soutenances).
    public const ADMIN = "ROLE_ADMIN";
    // Les pairs/étudiants.
    public const PEER = "ROLE_PEER";
    // Les membres de jury.
    public const JURY = "ROLE_JURY";
    // Les organisateurs de soutenances.
    public const CREATOR = "ROLE_CREATOR";

}