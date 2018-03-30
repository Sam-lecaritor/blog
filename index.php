<?php

require 'app/bootstrap.php';

if(isset($_GET['url'])){

    $urlarray = explode('/', $_GET['url']);
   // d($_GET['url']);
   // d($urlarray);
 
}else{

    $urlarray[0]='Home';
}

    switch ($urlarray[0]) {
        case 'Home':

            $articles= new Controllers\Articles_controller($twig);
            $articles->afficherListeArticles('Accueil');
            break; 

        case 'chapitres':

            $articles= new Controllers\Articles_controller($twig);
            $articles->afficherListeArticles('Chapitres');
            break;

        case 'chapitre':

            $articles= new Controllers\Articles_controller($twig);
            $articles->afficherArticle($urlarray[1]);
            break;   
            
         case 'admin':
            $articles= new Controllers\Admin_controller($twig);
            $articles->afficherAdmin($urlarray);

            break;    


        case 'home3':

            break;

            default:
            echo "page erreur 404";

    }
