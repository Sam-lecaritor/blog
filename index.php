<?php

require 'app/bootstrap.php';

if(isset($_GET['url'])){

    $urlarray = explode('/', $_GET['url']);

}else{

    $urlarray[0]='Home';
}

    switch ($urlarray[0]) {

        /**page d'accueil du site */
        case 'Home':

            $articles= new Controllers\Articles_controller($twig);
            $articles->afficherListeArticles('Accueil');
            break; 
        /**page de la liste des articles coté utilisateurs */
        case 'chapitres':

            $articles= new Controllers\Articles_controller($twig);
            $articles->afficherListeArticles('Chapitres', $urlarray);
            break;
        /** page single article */
         case 'chapitre':

            $articles= new Controllers\Articles_controller($twig);
            $articles->afficherArticle($urlarray[1]);
            break;    
        /** adimistration du site */
         case 'admin':
            $articles= new Controllers\Admin_controller($twig);
            $articles->afficherAdmin($urlarray);
            break;    

            default:
            echo $twig->render('page404.twig', array());

    }
