<?php

namespace App\Utilities;

/**
 * Classe définissant les différentes stratégies
 * permettant de considérer que l'évaluation d'une fiche d'évalution
 * (classe GradingGrid) est complète ou non.
 */
abstract class CompletionPolicy {

    /**
     * Exige que la fiche d'évaluation soit remplie en 
     * entier.
     */
    public const FULL_GRID = 0;

    /**
     * Exige qu'au moins une rubrique de la fiche d'évaluation 
     * soit remplie en entier.
     */
    public const FULL_RUBRIC = 1;

    /**
     * N'impose aucune restriction sur la manière 
     * dont un utilisateur remplit la 
     * fiche d'évaluation.
     */
    public const NO_RESTRICTION = 2;

}