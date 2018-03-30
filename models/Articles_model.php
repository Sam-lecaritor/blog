<?php
namespace Models;


class Articles_model{

private $db;

    public function __construct(){

        $db = new \App\Db_connect();
        $this->db = $db->connect();

    }

    public function getListeArticles(){

    $billets = $this->db->query('select * from articles');

    if($billets){
        return $billets->fetchall();
    }else{
        return null;
    }

    }

   public function getArticleBySlug($slug){

    $slug= filter_var($slug, FILTER_SANITIZE_URL);

    $billet = $this->db->prepare('select * from articles WHERE slug=?');

    $billet->execute(array($slug));
 
    return $billet->fetch();

    }

   public function getArticleById($idChapitre){

   

    $billet = $this->db->prepare('select * from articles WHERE id_chapitre=?');

    $billet->execute(array($idChapitre));
 
    return $billet->fetch();

    }


   public function setArticle($datas){

    $billet = $this->db->prepare("INSERT INTO articles (title, text, slug, id_chapitre) VALUES (:title, :text, :slug, :id_chapitre)");

    $billet->bindParam(':title', $title);
    $billet->bindParam(':text', $text);
    $billet->bindParam(':slug', $slug);
    $billet->bindParam(':id_chapitre', $id_chapitre);

    $title= $datas['titre'];
    $text= $datas['texte'];
    $slug= preg_replace('`[^a-z0-9]+`', '-', $datas['slug'] );
    $slug=trim($slug, '-');
    $id_chapitre= $datas['chapitre'];

   return $billet->execute();
 

    }



}
/* 
    $bdd = $this->getBdd();
    $commentaires = $bdd->prepare('select COM_ID as id, COM_DATE as date,'
    . ' COM_AUTEUR as auteur, COM_CONTENU as contenu from T_COMMENTAIRE'
    . ' where BIL_ID=?');
    $commentaires->execute(array($idBillet));
    return $commentaires; */