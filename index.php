<?php

require 'app/bootstrap.php';


if(isset($_GET['url'])){

    d($_GET['url']);
    $url=$_GET['url'];
}else{

    $url='home';
}

//ob_start();
    switch ($url) {
        case 'Home':

            $articles= new Controllers\Articles_controller($twig);
            $articles->afficherListeArticles();
            break; 

        case 'chapitres':

            $articles= new Controllers\Articles_controller($twig);
            $articles->afficherListeArticles();
            break;

        case 'home3':

            break;

            default:
            echo "i égal default";

    }
