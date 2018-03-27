<?php
namespace Controllers;
//require 'models/Articles_model.php';

class Admin_controller {

private $template;
//private $article_model;

public function __construct($twig){

$this->template = $twig;
//$this->article_model = new \Models\Articles_model();


//d($articles->getListeArticles());

}


public function afficherAdmin($params){

//$listeArticles = $this->article_model->getListeArticles();
d($params);

if(isset($params[1]) && $params[1] === 'articles' && !isset($params[2])){

    echo $this->template->render('back/articles.twig', array(
        'moteur_name' => 'Twig'
    ));

}
if(isset($params[1]) && $params[1] === 'articles' && isset($params[2]) && $params[2] === 'ajouter'){

    echo $this->template->render('back/editeurAricles.twig', array(
        'moteur_name' => 'Twig'
    ));

}
if((isset($params[1]) && $params[1] ==='dashboard' ) || !isset($params[1])){

        echo $this->template->render('back/dashboard.twig', array(
        'moteur_name' => 'Twig'
    ));
}





/*     echo $this->template->render('back/admin.twig', array(
        'moteur_name' => 'Twig'
    )); */

}



}
