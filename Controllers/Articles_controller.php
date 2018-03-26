<?php
namespace Controllers;
require 'models/Articles_model.php';

class Articles_controller {

private $template;
private $article_model;

public function __construct($twig){

$this->template = $twig;
$this->article_model = new \Models\Articles_model();


//d($articles->getListeArticles());

}


public function afficherListeArticles(){

$listeArticles = $this->article_model->getListeArticles();

    echo $this->template->render('articles.twig', array(
        'moteur_name' => 'Twig',
        'articles' => $listeArticles
    ));


}

}