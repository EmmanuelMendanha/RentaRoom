<?php

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;
    
    // Ce fichier contient la définition de la classe Kernel.
    // La classe Kernel est responsable de la gestion du cycle de vie de l'application Symfony.
    // Elle utilise le trait MicroKernelTrait pour ajouter des fonctionnalités supplémentaires.
}
