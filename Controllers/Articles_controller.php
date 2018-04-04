<?php
namespace Controllers;
require 'models/Articles_model.php';

class Articles_controller {


    private $template;
    private $article_model;



    public function __construct($twig){

        $this->template = $twig;
        $this->article_model = new \Models\Articles_model();
    }


    public function afficherListeArticles($title, $url=null){

        $nbr_pages= $this->article_model->countPagesPublishedArticles();
       
        if(!isset($url[1]) || $url[1] < 1 ){

        $listeArticles = $this->article_model->getListePublishedArticlesLimit(1);
        $url[1]=1;

        }elseif(isset($url[1])){
            
            $listeArticles = $this->article_model->getListePublishedArticlesLimit($url[1]);
        }

        

        echo $this->template->render('articles.twig', array(
            'page_title' => $title,
            'articles' => $listeArticles,
            'index_page' => intval($url[1]),
            'nbr_pages' => $nbr_pages
        ));
    }


    public function afficherArticle($slug){

        $article = $this->article_model->getArticleBySlug($slug);
        d($article);
        if($article){

            echo $this->template->render('SingleArticles.twig', array(
            'page_title' => $article["slug"],
            'moteur_name' => 'Twig',
            'article' => $article
        ));
        }else{
            $this->getPage404();
        }
    }


    public function getPageIndex(){

        echo $this->template->render('index.twig', array());
    }


    public function getPage404(){

        echo $this->template->render('page404.twig', array());
    }

}

