<?php

require 'app/bootstrap.php';


if(isset($_GET['url'])){

    $urlarray = explode('/', $_GET['url']);
   // d($_GET['url']);
   // d($urlarray);
 
}else{

    $urlarray='home';
}

    switch ($urlarray[0]) {
        case 'Home':

            $articles= new Controllers\Articles_controller($twig);
            $articles->afficherListeArticles();
            break; 

        case 'chapitres':

            $articles= new Controllers\Articles_controller($twig);
            $articles->afficherListeArticles();
            break;

        case 'chapitre':

            $articles= new Controllers\Articles_controller($twig);
            $articles->afficherArticle($urlarray[1]);
            break;   
            
         case 'admin':
    echo $twig->render('admin.twig', array(
        'moteur_name' => 'Twig'
    ));
            break;    


        case 'home3':

            break;

            default:
            echo "i égal default";

    }
