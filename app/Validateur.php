<?php
namespace App;

class Validateur{

private $article_model;



    public function __construct(){

    $this->article_model = new \Models\Articles_model();
    }


    public function formatSlug($slug){
        if(!isset($slug)){
        $slug= '';
        }else{
        $slug = preg_replace('`[^a-z0-9]+`', '-', $slug );
        $slug = trim($slug, '-');
        }
        return $slug;
    }

    public function checkSlug($datas, $slug){

        if($slug === ''){
            $datas['messages']['slug']= 'le slug  doit etre renseigné';
            $datas['checked']=false;
        }
    return $datas;
    }

    public function checkSlugExist($datas, $slug){

        if($this->article_model->getArticleBySlug($slug)){
            $datas['messages']['slug']= 'slug deja utilisé';
            $datas['checked']=false;
            }
        return $datas;
    }


//verification de la validité de l'entier pour le numero de chapitre
    public function checkChapitreIdValid($datas, $id){

        if(!filter_var(intval($id), FILTER_VALIDATE_INT)){
            $datas['messages']['chapitre']= 'numéro de chapitre invalide';
            $datas['checked']=false;
        }
        return $datas;
    }

//verifier si le numero de chapitre n'existe pas deja dans la base.
    public function checkChapitreIdExist($datas, $id){

        if($this->article_model->getArticleById($id)){
            $datas['messages']['chapitre']= 'numéro de chapitre deja utilisé';
            $datas['checked']=false;
        }
        return $datas;
    }

// verification de la validité de la chaine du titre
    public function checkTitre($datas, $title){

        if(!$title != ''){
            $datas['messages']['titre']= 'le titre doit etre renseigné';
            $datas['checked']=false;
        }
        return $datas;
    }

    public function checkTexte($datas, $text){
        if(!$text != ''){
        $datas['messages']['texte'] = 'le texte doit etre renseigné';
        $datas['checked']=false;
        }
        return $datas;
    }


    public function validerPostArticle($post){
 
        $post['messages'] = [];
        $post['checked'] = true;

  
        $post['slug'] = $this->formatSlug($post['slug']);
        $post = $this->checkSlug($post, $post['slug']);
        $post = $this->checkSlugExist($post, $post['slug']);
        $post = $this->checkChapitreIdExist($post, $post['chapitre']);
        $post = $this->checkChapitreIdValid($post, $post['chapitre']);
        $post = $this->checkTitre($post, $post['titre']);
        $post = $this->checkTexte($post, $post['texte']);

        return $validation = array(

        'checked'=>  $post['checked'],
        'messages' => $post['messages'],
        'post' => $post
            
        );
    }

    public function validerUpdateArticle($post){


        $datas['messages'] = [];
        $datas['checked'] = true;

        $post['slug'] =  $this->formatSlug($post['slug']);
        $post = $this->checkSlug($post, $post['slug']);
        $post = $this->checkChapitreIdValid($post, $post['chapitre']);
        $post = $this->checkTitre($post, $post['titre']);
        $post = $this->checkTexte($post, $post['texte']);

        return $validation = array(

        'checked'=>  $datas['checked'],
        'messages' => $datas['messages'],
        'post' => $post  
        );

    }





}