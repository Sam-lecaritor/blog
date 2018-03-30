<?php
namespace Controllers;


class Admin_controller {

private $template;
private $article_model;
private $validateur;

public function __construct($twig){

$this->template = $twig;
$this->article_model = new \Models\Articles_model();
$this->validateur = new \App\Validateur();


}


public function afficherAdmin($params){



//d($params);

if(isset($params[1]) && $params[1] === 'articles' && !isset($params[2])){

    $articles = $this->article_model->getListeArticles();
    //d($articles);
    echo $this->template->render('back/articles.twig', array(
        'articles' => $articles,
        'page_title' => 'ensemble des articles'
    ));

}


if(isset($params[1]) && $params[1] === 'articles' && isset($params[2])) {

    switch ($params[2]) {

        case 'ajouter':
            echo $this->template->render('back/editeurAricles.twig', array(
            'moteur_name' => 'Twig'
             ));
    
            break;

        case 'post':
           

        if(isset($_POST) ){

         $validateur = $this->validateur->validerPostArticle($_POST);

                if($validateur['checked'] === true){

                 $req = $this->article_model->setArticle($_POST);
 /*                    header('Location: /blog/admin');
                    exit(); */
                    if($req){

                        echo $this->template->render('back/editeurAricles.twig', array(
                        'article' => $validateur['post']
                        ));

                    }else{
                        echo $this->template->render('back/editeurAricles.twig', array(
                        'messages' => array(
                            'erreur' => "erreur dans l' enregistrement dans la base de données"
                        ),
                        'article' => $_POST
                        ));
                    }

                }else{

                    echo $this->template->render('back/editeurAricles.twig', array(
                    'messages' => $validateur['messages'],
                    'article' => $_POST
                    ));

                } 

            // $this->article_model->getListeArticles();

        }else{

             echo $this->template->render('back/editeurAricles.twig', array(
            'article' => $_POST
             ));

        }
 
            break;

            default:
            echo "page erreur 404";
}


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
