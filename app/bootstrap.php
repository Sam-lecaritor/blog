<?php
namespace App;
require 'vendor/autoload.php';
require 'Controllers/Articles_controller.php';
require 'Controllers/Admin_controller.php';



//require 'Db_connect.php';


    $loader = new \Twig_Loader_Filesystem('views/templates'); // Dossier contenant les templates
    $twig = new \Twig_Environment($loader, array(
      'cache' => false
    ));