<?php
namespace App;
require 'vendor/autoload.php';
//require 'Db_connect.php';


    $loader = new \Twig_Loader_Filesystem('views/templates'); // Dossier contenant les templates
    $twig = new \Twig_Environment($loader, array(
      'cache' => false
    ));