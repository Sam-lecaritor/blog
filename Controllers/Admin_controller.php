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


public function afficherAdmin(){

//$listeArticles = $this->article_model->getListeArticles();

    echo $this->template->render('back/admin.twig', array(
        'moteur_name' => 'Twig'
    ));

}
/*

public function afficherArticle($slug){

$article = $this->article_model->getArticle($slug);
d($article);
    echo $this->template->render('SingleArticles.twig', array(
        'moteur_name' => 'Twig',
        'article' => $article
    ));


} */


}
