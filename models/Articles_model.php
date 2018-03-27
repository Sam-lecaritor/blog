<?php
namespace Models;
require 'app/Db_connect.php';

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

   public function getArticle($slug){

    $slug= filter_var($slug, FILTER_SANITIZE_URL);

    $billet = $this->db->prepare('select * from articles WHERE slug=?');

    $billet->execute(array($slug));
 
    return $billet->fetch();

    }


}
/* 
    $bdd = $this->getBdd();
    $commentaires = $bdd->prepare('select COM_ID as id, COM_DATE as date,'
    . ' COM_AUTEUR as auteur, COM_CONTENU as contenu from T_COMMENTAIRE'
    . ' where BIL_ID=?');
    $commentaires->execute(array($idBillet));
    return $commentaires; */