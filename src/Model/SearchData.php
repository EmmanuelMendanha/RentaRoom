<?php

namespace App\Model;

class SearchData  // Classe SearchData contient deux propriétés publiques : page et q
{
    /** @var int */
    public $page = 1; // Page par défaut

    /** @var string */
    public string $q = ''; // Recherche par mot clé
}