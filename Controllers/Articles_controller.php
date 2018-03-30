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


public function afficherListeArticles($title){

$listeArticles = $this->article_model->getListeArticles();

    echo $this->template->render('articles.twig', array(
        'page_title' => $title,
        'moteur_name' => 'Twig',
        'articles' => $listeArticles
    ));


}


public function afficherArticle($slug){

$article = $this->article_model->getArticleBySlug($slug);
d($article);
    echo $this->template->render('SingleArticles.twig', array(
        'page_title' => $article["slug"],
        'moteur_name' => 'Twig',
        'article' => $article
    ));


}


}

