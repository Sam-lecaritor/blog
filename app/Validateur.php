<?php
namespace App;

class Validateur{
private $article_model;

public function __construct(){

    $this->article_model = new \Models\Articles_model();
}



    public function validerPostArticle($post){
$messages=[];
$checked= true;
 $post['slug'] =  preg_replace('`[^a-z0-9]+`', '-', $post['slug'] );
  $post['slug'] = trim($post['slug'], '-');

//verifier si le numero de chapitre n'existe pas deja dans la base.

//verification de la validité de l'entier pour le numero de chapitre
if(!filter_var(intval($post['chapitre']), FILTER_VALIDATE_INT)){
$messages['chapitre']= 'numéro de chapitre invalide';
$checked=false;
}elseif($this->article_model->getArticleById($post['chapitre'])){

$messages['chapitre']= 'numéro de chapitre deja utilisé';
$checked=false;

}
// verification de la validité de la chaine du titre
if(!$post['titre'] != ''){
$messages['titre']= 'le titre doit etre renseigné';
$checked=false;
}
//verification du slug
if(!$post['slug'] != ''){
$messages['slug']= 'le slug  doit etre renseigné';
$checked=false;

}elseif($this->article_model->getArticleBySlug($post['slug'])){

$messages['chapitre']= 'slug deja utilisé';
$checked=false;

}
 


//verification que le texte ne soit pas vide

if(!$post['texte'] != ''){

$messages['texte'] = 'le texte doit etre renseigné';
$checked=false;
}


        return $validation = array(

        'checked'=>  $checked,
        'messages' => $messages,
        'post' => $post
            
        );

    }


}