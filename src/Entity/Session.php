<?php

namespace App\Entity;

// Doctrine annotations
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * 
 * Classe représentant les sessions de soutenances.
 */
class Session {

    /**
     * 
     * L'identifiant de la session.
     * Clé primaire en BDD.
     */
    private int $id;

    /**
     * 
     * Le nome de la session de soutenance.
     */
    private string $name;

    /**
     * 
     * Une description facultative de la session 
     * de soutenances.
     */
    private string $description;

    /**
     * 
     * La date de début de la session de soutenance.
     */
    private $startDate;

    /**
     * 
     * La date de fin de la session de soutenances.
     */
    private $endDate;

    /**
     * 
     * La fiche d'évaluation utilisée pour évaluer 
     * les soutenanaces de la session.
     */
    private $gradingGrid;

    /**
     * 
     * La stratégie à utiliser pour clôturer la session 
     * de soutenanaces.
     */
    private $terminationPolicy;

    public function __construct()
    {

    }
}
