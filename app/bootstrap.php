<?php
namespace App;

session_start();

//autoloading de composer
require 'vendor/autoload.php';

//decalartion du moteur de template twig
//passer le cache a true en prod
    $loader = new \Twig_Loader_Filesystem('views/templates'); // Dossier contenant les templates
    $twig = new \Twig_Environment($loader, array(
      'cache' => false
    ));