<?php

namespace App\Security;

/**
 * Définit les statuts possibles d'une demande 
 * de création de compte organisateur sous forme
 * de constantes statiques.
 */
abstract class Status {

    public const VALIDATED = "VALIDATED";
    public const PENDING = "PENDING";

}